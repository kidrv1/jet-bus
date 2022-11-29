<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Cart;
use App\Models\Status;
use App\Models\Booking;
use App\Models\Package;
use Carbon\CarbonPeriod;
use App\Models\CartAddon;
use App\Models\BookingAddon;
use Illuminate\Http\Request;
use App\Service\NotifService;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cartItems = Cart::with(['package', 'addons.addonRef'])->where('user_id', auth()->id())->oldest()->get();
        $add_total = 0;
        $sub_total = 0;


        if (count($cartItems) != 0) {
            // Add Initial Booking To Base Cost
            $sub_total = (float) $cartItems[0]->package->package_rate;

            foreach ($cartItems as $index => $item) {
                // Add Addons To Additional Cost

                foreach ($item->addons as $addon) {
                    $add_total += (float) $addon->addonRef->price;
                }

                // Dont Add Initial Booking To Additonal Cost
                if ($index == 0) {
                    continue;
                }

                // Add Other Bookings Rate To Additional Cost
                $add_total += (float) $item->package->package_rate;
            }
        }


        return view("cart")->with([
            'cartItems' => $cartItems ?? [],
            'sub_total' => $sub_total ?? 0,
            'add_total' => $add_total ?? 0,
            'total' => ($sub_total + $add_total) ?? 0,
        ]);
    }

    public function count(Request $request)
    {
        $count = Cart::where('user_id', auth()->id())->count();

        return response()->json(["count" => $count ?? 0], 200);
    }

    public function add(Request $request)
    {
        try {
            $request->validate([
                'package_id' => ['required', 'integer'],
                'booking_date' => ['required', 'date'],
                'booking_date_end' => ['required', 'date'],
                'addons' => ["array", "nullable"],
            ]);

            $cartItem = Cart::where('user_id', auth()->id())
                ->where('package_id', $request->package_id)
                ->first();

            $package = Package::find($request->package_id);

            if ($package == null) {
                throw new Exception('Package not found');
            }

            if ($cartItem == null) {
                $cartItem = Cart::create([
                    "user_id" => auth()->id(),
                    "package_id" => $request->package_id,
                    "booking_date" => $request->booking_date,
                    "booking_date_end" => $request->booking_date_end,
                ]);

                if (!empty($request->addons)) {
                    foreach ($request->addons as $addon) {
                        CartAddon::create([
                            "cart_id" => $cartItem->id,
                            "package_addon_id" => $addon,
                        ]);
                    }
                }
            }

            return response()->json([
                "message" => "Package added to cart"
            ], 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                "message" => $th->getMessage()
            ], 400);
        }
    }

    public function remove(Request $request, $id)
    {
        try {
            $cartItem = Cart::find($id);

            if ($cartItem != null) {
                CartAddon::where("cart_id", $cartItem->id)->delete();
                $cartItem->delete();
            }

            return redirect()->route('my_cart')->with([
                'success' => 'Item removed!'
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->route('my_cart')->with([
                'error' => 'Unable to remove item!'
            ]);
        }
    }

    public function checkout(Request $request)
    {
        DB::beginTransaction();
        try {
            $user_id = auth()->id();
            $cartItems = Cart::with(['package', "addons.addonRef"])->where('user_id', $user_id)->oldest()->get();

            if (count($cartItems) == 0) {
                throw new Exception("No items in cart");
            }

            // Validate no booking dates overlap
            $reservedDates = [];
            foreach ($cartItems as $booking) {
                $period = CarbonPeriod::create($booking->booking_date, $booking->booking_date_end);
                foreach ($period as $date) {
                    array_push($reservedDates, $date->format('m/d/Y'));
                }
            }

            $temp_array = array_unique($reservedDates);
            if (sizeof($temp_array) != sizeof($reservedDates)) {
                throw new Exception("One or more of your bookings have overlapping dates");
            }

            // Book Initial
            $baseBooking = Booking::create([
                "user_id" => $user_id,
                "package_id" => $cartItems[0]->package->id,
                "booking_date" => $cartItems[0]->booking_date,
                "booking_date_end" => $cartItems[0]->booking_date_end,
                "status_id" => Status::PENDING,
                "parent_id" => null
            ]);

            // Book Initial Addons
            $baseBookingAddons = CartAddon::with(["addonRef"])->where("cart_id", $cartItems[0]->id)->get();
            foreach ($baseBookingAddons as $addon) {
                BookingAddon::create([
                    "booking_id" => $baseBooking->id,
                    "name" => $addon->addonRef->name,
                    "price" => $addon->addonRef->price,
                ]);
            }


            (new NotifService())->sendNotification(
                $user_id,
                "Booking Created",
                "Your " . "#$baseBooking->id " . $cartItems[0]->package->package_name . " booking for " . date("M d, Y", strtotime($cartItems[0]->booking_date)) . " has been created."
            );

            // Book Addons
            foreach ($cartItems as $index => $item) {
                if ($index != 0) {
                    $booking = Booking::create([
                        "user_id" => $user_id,
                        "package_id" => $item->package->id,
                        "booking_date" => $item->booking_date,
                        "booking_date_end" => $item->booking_date_end,
                        "status_id" => Status::PENDING,
                        "parent_id" => $baseBooking->id
                    ]);

                    foreach ($item->addons as $addon) {
                        BookingAddon::create([
                            "booking_id" => $booking->id,
                            "name" => $addon->addonRef->name,
                            "price" => $addon->addonRef->price,
                        ]);
                    }

                    (new NotifService())->sendNotification(
                        $user_id,
                        "Booking Created",
                        "Your addon for " . "#$baseBooking->id - #$booking->id"  . $item->package->package_name . " booking for " . date("M d, Y", strtotime($item->booking_date)) . " has been created."

                    );
                }
            }

            // Clear Cart Item
            foreach ($cartItems as $item) {
                CartAddon::where("cart_id", $item->id)->delete();
                $item->delete();
            }

            DB::commit();

            return redirect()->route('customer_booking_list')->with([
                'success' => 'Bookings created'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
            return redirect()->route('my_cart')->with([
                'error' => $th->getMessage()
            ]);
        }
    }
}