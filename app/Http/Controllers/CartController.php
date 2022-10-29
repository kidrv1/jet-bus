<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Cart;
use App\Models\Booking;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Service\NotifService;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cartItems = Cart::with(['package'])->where('user_id', auth()->id())->oldest()->get();
        $add_total = 0;
        $sub_total = 0;

        if (count($cartItems) != 0) {
            $sub_total = $cartItems[0]->package->package_rate;

            foreach ($cartItems as $index => $item) {
                if ($index == 0) {
                    continue;
                }

                $add_total += $item->package->package_rate;
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
                'booking_date' => ['required', 'date']
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
                ]);
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
            $cartItems = Cart::with(['package'])->where('user_id', $user_id)->oldest()->get();

            if (count($cartItems) == 0) {
                throw new Exception("No items in cart");
            }

            // Book Initial
            $baseBooking = Booking::create([
                "user_id" => $user_id,
                "package_id" => $cartItems[0]->package->id,
                "booking_date" => $cartItems[0]->booking_date,
                "status_id" => 1,
                "parent_id" => null
            ]);


            (new NotifService())->sendNotification(
                $user_id,
                "Booking Created",
                "Your " . $cartItems[0]->package->package_name . " booking for " . date("M d, Y", strtotime($cartItems[0]->booking_date)) . " has been created."
            );

            // Book Addons
            foreach ($cartItems as $index => $item) {
                if ($index != 0) {
                    Booking::create([
                        "user_id" => $user_id,
                        "package_id" => $item->package->id,
                        "booking_date" => $item->booking_date,
                        "status_id" => 1,
                        "parent_id" => $baseBooking->id
                    ]);

                    (new NotifService())->sendNotification(
                        $user_id,
                        "Booking Created",
                        "Your addon " . $item->package->package_name . " booking for " . date("M d, Y", strtotime($item->booking_date)) . " has been created."

                    );
                }
            }

            // Clear Cart Item
            foreach ($cartItems as $item) {
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