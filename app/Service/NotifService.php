<?php

namespace App\Service;

use App\Models\Notification;
use Illuminate\Support\Facades\Log;

class NotifService
{

    /**
     * Sends a notification to the user
     *
     * @param int $recipient_id
     * @param string $subject
     * @param string $message
     * @return Notification|null
     */
    public function sendNotification($recipient_id, $subject, $message): ?Notification
    {
        try {
            $notif = Notification::create([
                'user_id' => $recipient_id,
                'subject' => $subject,
                'message' => $message,
            ]);
        } catch (\Throwable $th) {
            Log::warning($th);
            return null;
        }

        return $notif;
    }
}