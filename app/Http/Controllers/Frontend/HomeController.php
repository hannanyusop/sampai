<?php

namespace App\Http\Controllers\Frontend;

use App\Domains\Auth\Models\Parcels;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        return view('frontend.index');
    }

    public function track(Request $request){

        if(trackEnabled()){

            $parcel = null;

            if($request->tracking_no){
                $parcel = Parcels::where('tracking_no', $request->tracking_no)->first();
            }

            return view('frontend.track', compact('parcel'));

        }else{
            return  redirect()->route('frontend.index')->withErrors('Action Not Allowed!');

        }

    }
}
