<?php

namespace App\Notifications;

use App\Domains\Auth\Models\Parcels;
use App\Services\Parcel\ParcelHelperService;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

class ParcelStatusNotification extends Notification
{
    use Queueable;

    protected Parcels $parcel;
    protected int $status;

    public function __construct(Parcels $parcel, int $status)
    {
        $this->parcel = $parcel;
        $this->status = $status;
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
        $statusLabel = ParcelHelperService::statuses($this->status);
        $trackingNo = $this->parcel->tracking_no;
        $link = $this->parcel->pickup_id
            ? route('frontend.user.pickup.show', encrypt($this->parcel->pickup_id))
            : url('/');

        return FcmMessage::create()
            ->setData([
                'parcel_id' => (string) $this->parcel->id,
                'tracking_no' => $trackingNo,
                'status' => (string) $this->status,
                'link' => $link,
            ])
            ->setNotification(
                FcmNotification::create()
                    ->setTitle("Parcel #{$trackingNo}")
                    ->setBody($statusLabel)
            );
    }
}
