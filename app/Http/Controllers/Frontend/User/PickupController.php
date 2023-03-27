<?php

namespace App\Http\Controllers\Frontend\User;

use App\Domains\Auth\Models\Parcels;
use App\Http\Controllers\Controller;
use App\Models\Pickup;

class PickupController extends Controller
{
    public function index(){

        $pickups = Pickup::where('user_id', auth()->user()->id)
            ->get();
        return view('frontend.user.pickup.index', compact('pickups'));
    }

    public function view($id){

        $pickups = Pickup::with('Parcels')->where([
            'user_id' => auth()->user()->id
        ])->find(decrypt($id));

        if(!$pickups){
            return redirect()->back()->with('warning', 'Parcel not found!');
        }

        return view('frontend.user.pickup.view', compact('pickups'));
    }

}
