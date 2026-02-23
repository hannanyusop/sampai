<?php

namespace App\Jobs;

use App\Models\Pickup;
use App\Models\PickupNotification;
use App\Notifications\PickupReadyNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendPickupPushNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $pickupId;

    public function __construct(int $pickupId)
    {
        $this->pickupId = $pickupId;
    }

    public function handle(): void
    {
        $pickup = Pickup::with(['user', 'parcels', 'dropPoint'])->find($this->pickupId);

        if (!$pickup) {
            return;
        }

        $user = $pickup->user;
        if (!$user || empty($user->fcm_token)) {
            return;
        }

        $notification = PickupNotification::create([
            'pickup_id' => $pickup->id,
            'via' => PickupNotification::VIA_FCM,
            'address' => 'fcm_token',
            'content' => 'Pickup #' . $pickup->code . ' - ' . $pickup->parcels->count() . ' parcel(s) ready to collect',
            'status' => PickupNotification::STATUS_PENDING,
        ]);

        try {
            $user->notify(new PickupReadyNotification($pickup));

            $notification->update([
                'status' => PickupNotification::STATUS_SENT,
                'provider_remark' => 'Push notification sent successfully',
            ]);

            $pickup->update([
                'notification_sent' => 1,
                'notification_send_at' => now(),
            ]);
        } catch (\Exception $e) {
            $notification->update([
                'status' => PickupNotification::STATUS_FAILED,
                'provider_remark' => $e->getMessage(),
            ]);
        }
    }
}
