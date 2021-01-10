<?php
namespace App\Http\Controllers\Frontend\User;

use App\Domains\Auth\Models\Parcels;
use App\Domains\Auth\Models\TrackHistories;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ParcelController extends Controller{


    public function search(Request $request){
        $parcel = null;

        if($request->tracking_no){

            if(paymentEnabled()){

                $bal = getMaxTrack()-auth()->user()->todayTracks->count();

                if($bal > 0){

                    $track = new TrackHistories();
                    $track->user_id = auth()->user()->id;
                    $track->tracking_no = $request->tracking_no;
                    $track->save();
                }else{

                    return redirect()->route('frontend.user.parcel.search')->withErrors('You already reach limit for today.');
                }

            }
            $parcel = Parcels::where('tracking_no', $request->tracking_no)->first();
        }

        return view('frontend.user.parcel.search', compact('parcel'));
    }
}
