<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // Check if booking exists
        $booking_id = $request->query("q", null);
        $booking = Booking::with(['package', 'feedback'])->find($booking_id);

        if ($booking == null) {
            return redirect()->route("home");
        }

        // Check if booking already has feedback
        $feedback = $booking->feedback()->get();
        if (count($feedback) != 0) {
            return view("feedback.show")->with(["booking" => $booking]);
        }

        if (auth()->user()->hasAnyRole(['admin', 'staff'])) {
            return back()->with('success', 'Booking has no feedback yet');
        }

        return view("feedback.create")->with(["booking" => $booking]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "booking_id" => ["required"],
            "subject" => ["required"],
            "message" => ["required"],
        ]);

        $booking = Booking::find($request->booking_id);
        if ($booking == null) {
            return redirect()->route("home");
        }

        Feedback::create([
            "booking_id" => $request->booking_id,
            "user_id" => auth()->id(),
            "subject" => $request->subject,
            "message" => $request->message,
        ]);

        return redirect()->route("home")->with([
            "success" => "Thank you for your feedback."
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        $feedback = $booking->feedback()->get();

        if ($feedback == null) {
            return redirect()->route("home");
        }

        return view("feedback.show")->with([
            "feedback" => $feedback
        ]);
    }
}