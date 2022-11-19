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

        $inCart = Cart::where('user_id', auth()->id())
            ->where('package_id', $package->id)
            ->first();

        return view("package.show")->with([
            "randomPackages" => $randomPackages ?? [],
            "package" => $package,
            "inclusions" => json_decode($package->inclusion),
            "inCart" => $inCart ?? null,
            "reserved_dates" => $reservedDates,
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
}