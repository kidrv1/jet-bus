<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\TryCatch;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //TODO: add filters

        $filter = $request->query('filter', null);
        $limit = $request->query('limit', null);
        $notifications = null;

        switch ($filter) {
            case "unread":
                $notifications = Notification::where('user_id', auth()->id())
                    ->where('isRead', 0)
                    ->latest()
                    ->limit($limit)
                    ->get();
                break;
            case "read":
                $notifications = Notification::where('user_id', auth()->id())
                    ->where('isRead', 1)
                    ->latest()
                    ->limit($limit)
                    ->get();
                break;
            default:
                $notifications = Notification::where('user_id', auth()->id())
                    ->latest()
                    ->limit($limit)
                    ->get();
                break;
        }
        return view("notifications")->with([
            "notifications" => $notifications ?? []
        ]);
    }

    /**
     * Display the count of unread notifications.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function unreadCount(Request $request)
    {
        try {
            $notificationsCount = Notification::where("user_id", auth()->id())
                ->where("isRead", 0)
                ->count();

            return response()->json([
                "count" => $notificationsCount ?? 0
            ], 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                "count" => 0
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $notif_id = $request->query("q", null);
        try {
            $notif = Notification::find($notif_id);

            if ($notif_id == null) {
                throw new Exception("No notification found");
            }

            if ($notif->user_id != auth()->id()) {
                throw new Exception("Does not belong to this user");
            }

            if ($notif->isRead == false) {
                $notif->isRead = true;
                $notif->save();
            }
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                "message" => "Unable to update notification"
            ], 400);
        }

        return response()->json([
            "message" => "Notification updated as read"
        ], 200);
    }

    public function unread(Request $request)
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->where('isRead', 0)
            ->latest()
            ->limit(5)
            ->get();

        return response()->json([
            "notifications" => $notifications
        ], 200);
    }
}