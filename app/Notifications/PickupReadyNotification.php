<?php

namespace App\Notifications;

use App\Models\Pickup;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

class PickupReadyNotification extends Notification
{
    use Queueable;

    protected Pickup $pickup;

    public function __construct(Pickup $pickup)
    {
        $this->pickup = $pickup;
    }

    public function via($notifiable): array
    {
        if (empty($notifiable->fcm_token)) {
            return [];
        }

        return [FcmChannel::class];
    }

    public function toFcm($notifiable): FcmMessage
    {
        $pickupCode = $this->pickup->code;
        $parcelCount = $this->pickup->parcels->count();
        $dropPoint = $this->pickup->dropPoint?->name ?? '';
        $link = route('frontend.user.pickup.show', encrypt($this->pickup->id));

        return FcmMessage::create()
            ->setData([
                'pickup_id' => (string) $this->pickup->id,
                'pickup_code' => $pickupCode,
                'link' => $link,
            ])
            ->setNotification(
                FcmNotification::create()
                    ->setTitle("Pickup #{$pickupCode}")
                    ->setBody(__(':count parcel(s) ready to collect at :location', [
                        'count' => $parcelCount,
                        'location' => $dropPoint,
                    ]))
            );
    }
}
