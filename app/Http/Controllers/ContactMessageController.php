<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use Illuminate\Support\Carbon;
use App\Http\Requests\StoreContactMessageRequest;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!auth()->user()->hasAnyRole(['admin', 'staff'])) {
            return redirect()->route("home");
        }

        $startDate = $request->from_date ? Carbon::parse($request->from_date)->startOfDay() : now()->startOfMonth();
        $endDate = $request->to_date ? Carbon::parse($request->to_date)->endOfDay() : now()->endOfMonth();

        $messages = ContactMessage::whereBetween("created_at", [$startDate->toDateTimeString(), $endDate->toDateTimeString()]);
        switch ($request->status) {
            case 'read':
                $messages = $messages->whereNotNull("read_at");
                break;
            case 'unread':
                $messages = $messages->whereNull("read_at");
                break;
            default:
                break;
        }
        $messages = $messages->latest()->get();

        return view("contact.index")->with(["messages" => $messages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("contact.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreContactMessageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContactMessageRequest $request)
    {
        $message = "";
        try {
            ContactMessage::create($request->validated());
            $message = "Message Sent!";
        } catch (\Throwable $th) {
            $message = "Unexpected Error, Unable To Send Message!";
            //throw $th;
        }
        return redirect()->back()->with(["message_status" => $message]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateContactMessageRequest  $request
     * @param  \App\Models\ContactMessage  $contactMessage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $message_id)
    {
        try {
            if (!auth()->user()->hasAnyRole(['admin', 'staff'])) {
                return response()->json(["message" => "forbidden"], 403);
            }

            $msg = ContactMessage::find($message_id);
            if ($msg == null) {
                return response()->json(["message" => "message not found"], 404);
            }

            $msg->read_at = now();
            $msg->save();

            return response()->json(["message" => "marked as read"], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "unexpected error, failed to update!"], 400);
        }
    }
}