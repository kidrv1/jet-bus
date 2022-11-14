<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\Booking;
use GuzzleHttp\Psr7\Request;
use App\Models\CancelRequest;
use App\Service\NotifService;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreCancelRequestRequest;
use App\Http\Requests\UpdateCancelRequestRequest;

class CancelRequestController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCancelRequestRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCancelRequestRequest $request)
    {
        DB::beginTransaction();
        try {
            $booking = Booking::with(["user"])->find($request->booking_id);
            if ($booking == null) {
                // return response()->json(["message" => "not found"], 404);
                return back()->with('error', 'Booking Not Found');
            }

            $cancelReq = CancelRequest::where("booking_id", $request->booking_id)->first();
            if ($cancelReq != null) {
                // return response()->json(["message" => "already requested"], 400);
                return back()->with('error', 'already requested cancellation');
            }

            $cancelReq = CancelRequest::create($request->validated());
            $booking->hasCancelRequest = true;
            $booking->save();

            DB::commit();
            // return response()->json(["message" => "cancel requested"], 201);
            return back()->with('success', 'cancel requested');
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            return back()->with('error', 'unexpected error, unable to cancel');
            // return response()->json(["message" => "unexpected error, unnable to cancel"], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  integer $requestId
     * @return \Illuminate\Http\Response
     */
    public function show($requestId)
    {
        $booking = Booking::with(["cancelRequest"])->find($requestId);

        if ($booking == null) {
            return response()->json(["message" => "not found"], 404);
        }

        if ($booking->cancelRequest == null) {
            return response()->json(["message" => "not found"], 404);
        }

        if ($booking->user_id != auth()->id()) {
            if (!auth()->user()->hasAnyRole(['admin', 'staff'])) {
                return response()->json(["message" => "forbidden"], 403);
            }
        }

        return response()->json(["data" => $booking->cancelRequest], 200);
    }

    public function update(UpdateCancelRequestRequest $request)
    {
        if (!auth()->user()->hasAnyRole(['admin', 'staff'])) {
            // return response()->json(["message" => "forbidden"], 403);
            return back()->with('error', 'Not Allowed');
        }

        $booking = Booking::with(["cancelRequest", "package"])->find($request->booking_id);

        if ($booking == null) {
            // return response()->json(["message" => "not found"], 404);
            return back()->with('error', 'Booking Not Found');
        }

        if ($booking->cancelRequest == null) {
            // return response()->json(["message" => "not found"], 404);
            return back()->with('error', 'Cancel Request Not Found');
        }

        $booking->status_id = Status::CANCELED;
        $booking->save();

        (new NotifService())->sendNotification(
            $booking->user_id,
            "Booking Cancelled",
            "Your " . $booking->package->package_name . " booking for " . date("M d, Y", strtotime($booking->booking_date)) . " has been cancelled."
        );

        // return response()->json([
        //     "message" => "booking cancelled",
        // ], 200);
        return back()->with('success', 'Cancel Request Approved');
    }
}