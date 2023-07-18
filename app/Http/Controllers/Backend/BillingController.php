<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Mail\Pickup\SendNotification;
use App\Models\Pickup;
use App\Models\TripBatch;
use Illuminate\Http\Request;
use Mail;

class BillingController extends Controller
{

    public function view(TripBatch $tripBatch){
        return view('backend.billing.view', compact('tripBatch'));
    }

    public function export(TripBatch $tripBatch){
        return (new \App\Exports\Trip\BillingListExport($tripBatch))->download('billing_'.$tripBatch->number.'_'.time().'.xlsx');
    }

    public function resendNotification(Pickup $pickup){

//        return view('email.pickup.send-notification', compact('pickup'));
//        $pickup->sendNotificationEmail();

        try {
            Mail::to('hannan135589@gmail.com')->send(new SendNotification($pickup));

            $this->update([
                'notification_sent' => 1,
                'notification_send_at' => now()
            ]);

            return redirect()->back()->with('success', 'Notification sent successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }



}
