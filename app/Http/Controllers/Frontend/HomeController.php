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

        $parcel = null;

        if($request->tracking_no){
            $parcel = Parcels::where('tracking_no', $request->tracking_no)->first();
        }

        return view('frontend.track', compact('parcel'));
    }
}
