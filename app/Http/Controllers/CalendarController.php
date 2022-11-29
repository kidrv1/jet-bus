<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\Booking;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        if (!auth()->user()->hasAnyRole(['admin', 'staff'])) {
            return back()->with('error', 'Forbbiden');
        }

        $events = [];
        $bookings = Booking::with(["package.bus", "user"])
            ->where("status_id", Status::APPROVED)
            // ->whereBetween('booking_date', [now()->startOfMonth(), now()->endOfMonth()])
            ->get();

        foreach ($bookings as $index => $booking) {
            $events[$index] = [
                "id" => $booking->id,
                "name" => $booking->package->package_name,
                "badge" => $booking->booking_date->format("m-d") . " - " . $booking->booking_date_end->format("m-d"),
                "description" => "Booking #: $booking->id " . "<br>Bus Plate: " . $booking->package->bus->plate .  "<br>Package Name: " .  $booking->package->package_name . "<br>Booking by: " . $booking->user->first_name . " " . $booking->user->last_name,
                "date" => [$booking->booking_date, $booking->booking_date_end],
                "type" => "holiday"
            ];
        }

        return view("calendar")->with(["events" => $events]);
    }
}