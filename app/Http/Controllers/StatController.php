<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class StatController extends Controller
{
    public function index(Request $request)
    {
        // Get Count Of Packages Bookings
        $bookings = Booking::with(["package", "addons"]);
        // ->where("status_id", "!=", Status::CANCELED)

        if ($request->has("from_date") && $request->from_date != null && $request->has("to_date") && $request->to_date != null) {
            $from = Carbon::parse($request->from_date);
            $to = Carbon::parse($request->to_date);
            $bookings = $bookings->whereBetween('created_at', [$from->startOfDay(), $to->endOfDay()]);
        }

        $bookings = $bookings->get();

        $bookingData = [];
        $bookingAddons = [];

        foreach ($bookings as $booking) {
            // Check if already in array
            if (array_key_exists($booking->package->id, $bookingData)) {
                $bookingData[$booking->package->id]["count"] += 1;
            } else {
                $bookingData[$booking->package->id] = [
                    "package_name" => $booking->package->package_name,
                    "count" => 1,
                    "top_addon" => null,
                    "top_addon_count" => null,
                ];
            }

            // Get Count Of Most Booked Addon
            foreach ($booking->addons as $addon) {
                if (!array_key_exists($addon->booking->package_id, $bookingAddons)) {
                    $bookingAddons[$addon->booking->package_id] = [];
                }
                array_push($bookingAddons[$addon->booking->package_id], $addon->name);
            }
        }

        // Calculate Most Popular Addon
        foreach ($bookingAddons as $idx => $addonArray) {
            $nameCount = array_count_values($addonArray);
            $topAddon = array_keys($nameCount, max($nameCount));
            $bookingData[$idx]["top_addon"] = $topAddon[0];
            $bookingData[$idx]["top_addon_count"] = max($nameCount);
            // dd($idx, $addonArray, $nameCount, $topAddon);
        }

        // Sort By Most Bookings
        usort($bookingData, function ($a, $b) {
            return $b["count"] - $a["count"];
        });

         dd($bookingData, $bookingAddons);

        return view("admin.stats")->with(["bookingData" => $bookingData]);
    }
}