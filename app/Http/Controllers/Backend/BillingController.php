<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Mail\Pickup\SendNotification;
use App\Models\Pickup;
use App\Models\PickupNotification;
use App\Models\TripBatch;
use App\Notifications\ParcelStatusNotification;
use App\Services\Parcel\ParcelHelperService;
use Illuminate\Http\Request;
use Mail;

class BillingController extends Controller
{

    public function view(TripBatch $tripBatch){

        $tripBatch = $tripBatch->load([
            'trips',
        ]);

        return view('backend.billing.view', compact('tripBatch'));
    }

    public function export(TripBatch $tripBatch){
        return (new \App\Exports\Trip\BillingListExport($tripBatch))->download('billing_'.$tripBatch->number.'_'.time().'.xlsx');
    }

    public function resendNotification(Pickup $pickup){

        $email = $pickup->user?->email ?? 'hannan135589@gmail.com';

        // Generate message content from office whatsapp_template
        $offices = \App\Domains\Auth\Models\Office::pluck('whatsapp_template', 'id')->toArray();
        $messageContent = \App\Services\Parcel\ParcelHelperService::GeneralWhatsappText($pickup, $offices);

        $notification = PickupNotification::create([
            'pickup_id' => $pickup->id,
            'via' => PickupNotification::VIA_EMAIL,
            'address' => $email,
            'content' => $messageContent,
            'status' => PickupNotification::STATUS_PENDING,
        ]);

        try {
            Mail::to($email)->send(new SendNotification($pickup, $messageContent));

            $notification->update([
                'status' => PickupNotification::STATUS_SENT,
                'provider_remark' => 'Email sent successfully',
            ]);

            $pickup->update([
                'notification_sent' => 1,
                'notification_send_at' => now()
            ]);

            return redirect()->back()->with('success', 'Notification sent successfully');
        } catch (\Exception $e) {
            $notification->update([
                'status' => PickupNotification::STATUS_FAILED,
                'provider_remark' => $e->getMessage(),
            ]);

            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    public function sendWhatsAppNotification(Pickup $pickup)
    {
        $phoneNumber = $pickup->user?->phone_number;

        if (empty($phoneNumber)) {
            return redirect()->back()->with('error', __('User does not have a phone number.'));
        }

        $offices = \App\Domains\Auth\Models\Office::pluck('whatsapp_template', 'id')->toArray();
        $message = \App\Services\Parcel\ParcelHelperService::GeneralWhatsappText($pickup, $offices);

        $notification = PickupNotification::create([
            'pickup_id' => $pickup->id,
            'via' => PickupNotification::VIA_WHATSAPP,
            'address' => $phoneNumber,
            'content' => $message,
            'status' => PickupNotification::STATUS_PENDING,
        ]);

        try {
            $service = new \App\Services\Twilio\TwilioWhatsAppService();
            $result = $service->send($phoneNumber, $message);

            $notification->update([
                'status' => PickupNotification::STATUS_SENT,
                'provider_remark' => 'Message SID: ' . ($result['sid'] ?? 'N/A'),
            ]);

            $pickup->update([
                'notification_sent' => 1,
                'notification_send_at' => now()
            ]);

            return redirect()->back()->with('success', __('WhatsApp notification sent!'));
        } catch (\Exception $e) {
            $notification->update([
                'status' => PickupNotification::STATUS_FAILED,
                'provider_remark' => $e->getMessage(),
            ]);

            return redirect()->back()->with('error', __('WhatsApp Error: ') . $e->getMessage());
        }
    }

    public function sendPushNotification(Pickup $pickup)
    {
        $user = $pickup->user;

        if (!$user || empty($user->fcm_token)) {
            return redirect()->back()->with('error', __('User does not have push notification enabled.'));
        }

        $pickup->load('parcels');

        $notification = PickupNotification::create([
            'pickup_id' => $pickup->id,
            'via' => PickupNotification::VIA_FCM,
            'address' => 'fcm_token',
            'content' => 'Push notification sent for ' . $pickup->parcels->count() . ' parcel(s)',
            'status' => PickupNotification::STATUS_PENDING,
        ]);

        try {
            foreach ($pickup->parcels as $parcel) {
                $user->notify(new ParcelStatusNotification($parcel, ParcelHelperService::STATUS_READY_TO_COLLECT));
            }

            $notification->update([
                'status' => PickupNotification::STATUS_SENT,
                'provider_remark' => 'Push notification sent successfully',
            ]);

            $pickup->update([
                'notification_sent' => 1,
                'notification_send_at' => now()
            ]);

            return redirect()->back()->with('success', __('Push notification sent successfully'));
        } catch (\Exception $e) {
            $notification->update([
                'status' => PickupNotification::STATUS_FAILED,
                'provider_remark' => $e->getMessage(),
            ]);

            return redirect()->back()->with('error', __('Push notification failed: ') . $e->getMessage());
        }
    }

    public function notificationHistory(Pickup $pickup)
    {
        $notifications = $pickup->notifications()->orderBy('created_at', 'desc')->get();

        return response()->json([
            'pickup_code' => $pickup->code,
            'notifications' => $notifications->map(function ($n) {
                return [
                    'id' => $n->id,
                    'via' => $n->via,
                    'via_badge' => $n->via_badge,
                    'address' => $n->address,
                    'content' => \Str::limit($n->content, 100),
                    'status' => $n->status,
                    'status_badge' => $n->status_badge,
                    'provider_remark' => $n->provider_remark,
                    'created_at' => $n->created_at->format('d M Y H:i'),
                ];
            }),
        ]);
    }

}
