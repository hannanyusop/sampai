<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\Pickup;

class PickupController extends Controller
{
    public function index(){
        return view('frontend.user.pickup.index');
    }

    public function view($id){

        $pickup = Pickup::with('Parcels')->where([
            'user_id' => auth()->user()->id
        ])->find(decrypt($id));

        if(!$pickup){
            return redirect()->back()->with('warning', 'Parcel not found!');
        }

        return view('frontend.user.pickup.view', compact('pickup'));
    }

}
