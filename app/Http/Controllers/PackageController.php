<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Status;
use App\Models\Booking;
use App\Models\Package;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function show(Request $request, $id)
    {
        $package = Package::with(['bus', 'addons'])->find($id);
        $randomPackages = Package::with(['bus'])
            ->where("isActive", true)
            ->inRandomOrder()
            ->limit(10)
            ->get();

        if ($package == null) {
            return redirect()->route("home");
        }

        $bookings = Booking::where("status_id", Status::APPROVED)
            ->where("package_id", $package->id)
            ->get();

        $reservedDates = [];
        foreach ($bookings as $booking) {
            $period = CarbonPeriod::create($booking->booking_date, $booking->booking_date_end);
            foreach ($period as $date) {
                array_push($reservedDates, $date->format('m/d/Y'));
            }
        }

        $topBookings = Booking::with(["package", "addons"])
            ->where("package_id", $package->id)
            ->get();

        $bookingAddons = [];
        foreach ($topBookings as $booking) {
            foreach ($booking->addons as $addon) {
                array_push($bookingAddons, $addon->name);
            }
        }

        if (!empty($bookingAddons)) {
            $nameCount = array_count_values($bookingAddons);
            $topAddon = array_keys($nameCount, max($nameCount));
            $topAddon = $topAddon[0];
        }

        $inCart = Cart::where('user_id', auth()->id())
            ->where('package_id', $package->id)
            ->first();


        return view("package.show")->with([
            "randomPackages" => $randomPackages ?? [],
            "package" => $package,
            "inclusions" => json_decode($package->inclusion),
            "inCart" => $inCart ?? null,
            "reserved_dates" => $reservedDates,
            "top_addon" => $topAddon ?? null,
        ]);
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            "package_id" => ["required"],
            "status" => ["required", "boolean"]
        ]);

        $package = Package::findOrFail($request->package_id);
        $package->isActive = $request->status;
        $package->save();


        return back()->with("success", "Package status updated");
    }

    public function find(Request $request)
    {
        $package = Package::find($request->package_id);
        return response()->json($package, 200);
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'package_id' => ["required"],
            'start_time'      => ['required'],
            'end_time'      => ['required'],
            'package_name'      => ['required'],
            'package_rate'     => ['required'],
            'inclusion'        => ['required'],
        ]);

        $validatedData['user_id'] = auth()->id();
        $validatedData['inclusion'] = json_encode($validatedData['inclusion']);

        Package::find($validatedData['package_id'])->update([
            "user_id" => $validatedData['user_id'],
            "start_time" => $validatedData['start_time'],
            "end_time" => $validatedData['end_time'],
            "package_name" => $validatedData['package_name'],
            "package_rate" => $validatedData['package_rate'],
            "inclusion" => $validatedData['inclusion'],
        ]);

        return back()->with('success', 'Bus Package Updated Successfully');
    }
}