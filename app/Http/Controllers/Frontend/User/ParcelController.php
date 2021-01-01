<?php
namespace App\Http\Controllers\Frontend\User;

use App\Domains\Auth\Models\Parcels;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ParcelController extends Controller{


    public function search(Request $request){
        $parcel = null;

        if($request->tracking_no){
            $parcel = Parcels::where('tracking_no', $request->tracking_no)->first();
        }

        return view('frontend.user.parcel.search', compact('parcel'));
    }
}
