<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

class FcmTokenController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $request->user()->update([
            'fcm_token' => $request->token,
        ]);

        return response()->json(['message' => 'Token saved']);
    }

    public function destroy(Request $request)
    {
        $request->user()->update([
            'fcm_token' => null,
        ]);

        return response()->json(['message' => 'Token revoked']);
    }

    public function testNotification(Request $request)
    {
        $user = $request->user();

        if (empty($user->fcm_token)) {
            return response()->json(['message' => 'No FCM token registered. Please re-register first.'], 422);
        }

        $message = FcmMessage::create()
            ->setData(['type' => 'test'])
            ->setNotification(
                FcmNotification::create()
                    ->setTitle('NUJ Express')
                    ->setBody('Congratulations! Notification successfully setup!')
            );

        $user->notify(new class($message) extends \Illuminate\Notifications\Notification {
            protected $message;
            public function __construct($message) { $this->message = $message; }
            public function via($notifiable) { return [FcmChannel::class]; }
            public function toFcm($notifiable) { return $this->message; }
        });

        return response()->json(['message' => 'Notification sent']);
    }
}
