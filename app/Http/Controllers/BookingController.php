<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\Booking;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // Unused - Moved logic to show package page
    public function getBookedPackageDates(Request $request)
    {
        $bookings = Booking::where("status_id", Status::APPROVED)
            ->where("package_id", $request->package_id)
            ->get();


        $reservedDates = [];
        foreach ($bookings as $booking) {
            $period = CarbonPeriod::create($booking->booking_date, $booking->booking_date_end);
            foreach ($period as $date) {
                array_push($reservedDates, $date->format('Y-m-d'));
            }
        }

        return response()->json(["reserved_dates" => $reservedDates], 200);
    }
}