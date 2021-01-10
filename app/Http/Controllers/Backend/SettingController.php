<?php
namespace App\Http\Controllers\Backend;

use App\Domains\Auth\Http\Requests\Backend\Setting\UpdatePaymentRequest;
use App\Domains\Auth\Http\Requests\Backend\Setting\UpdateSystemRequest;
use App\Domains\Auth\Models\Option;
use App\Domains\Auth\Models\Parcels;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller{

    public function payment(){


        return view('backend.setting.payment');
    }

    public function paymentSave(UpdatePaymentRequest $request){

        $options = ['payment_cost', 'payment_limit_query', 'payment_limit_top_up', 'payment_collection_id'];


        getOption('payment_enabled', true);

        $payment_enabled = Option::where('name', 'payment_enabled')->first();

        $payment_enabled->update([
            'value' => ($request->payment_enabled)? true : false
        ]);

        foreach ($options as $name){
            getOption($name, 'null');
            $option = Option::where('name', $name)->first();
            $option->update([
                'value' => request($name)
            ]);
        }

        return redirect()->back()->withFlashSuccess('Payment setting updated!');
   }

    public function system(){


        return view('backend.setting.system');
    }

    public function systemSave(UpdateSystemRequest $request){


        getOption('allow_registration', true);
        $allow_registration = Option::where('name', 'allow_registration')->first();
        $allow_registration->update([
            'value' => ($request->allow_registration)? true : false
        ]);

        getOption('allow_tracking', true);
        $show_tracking = Option::where('name', 'allow_tracking')->first();
        $show_tracking->update([
            'value' => ($request->show_tracking)? true : false
        ]);



        return redirect()->back()->withFlashSuccess('Payment setting updated!');
    }
}
