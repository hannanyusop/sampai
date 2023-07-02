<?php

namespace App\Services\Pickup;

use App\Domains\Auth\Models\Office;
use App\Domains\Auth\Models\Trip;
use App\Domains\Auth\Models\User;
use App\Models\Pickup;
use App\Services\General\GeneralHelperService;

class PickupGeneralService
{

    public static function getPickupByUser(User $user, Trip $trip, Office $office){

        $pickup = Pickup::where([
            'user_id'   => $user->id,
            'trip_id'   => $trip->id,
            'office_id' => $office->id,
        ])->first();

        if($pickup){
            return [
                GeneralHelperService::KEY_STATUS  => GeneralHelperService::STATUS_SUCCESS,
                GeneralHelperService::KEY_MESSAGE => __('Pickup exist'),
                GeneralHelperService::KEY_DATA    =>  $pickup
            ];
        }

        return self::add($user, $trip, $office);
    }

    public static function add(User $user, Trip $trip, Office $office)
    {

        $last    = Pickup::orderBy('id', 'DESC')->first();
        $next_id = ($last)? $last->id+1 : 1;

        $pickup = new Pickup();
        $pickup->user_id   = $user->id;
        $pickup->trip_id   = $trip->id;
        $pickup->office_id = $office->id;
        $pickup->code      = $office->code."-".$next_id;

        $pickup->save();

        return [
            GeneralHelperService::KEY_STATUS  => GeneralHelperService::STATUS_SUCCESS,
            GeneralHelperService::KEY_MESSAGE => __('New Pickup Created.'),
            GeneralHelperService::KEY_DATA    => $pickup
        ];

    }


    public function customerPickup($code){

        $pickup = Pickup::where([
            'code'   => $code
        ])->first();


        if(!$pickup){
            return [
                GeneralHelperService::KEY_STATUS  => GeneralHelperService::STATUS_ERROR,
                GeneralHelperService::KEY_MESSAGE => __('Code not found.'),
            ];
        }

        if($pickup->status == PickupHelperService::STATUS_PENDING){
            return [
                GeneralHelperService::KEY_STATUS  => GeneralHelperService::STATUS_ERROR,
                GeneralHelperService::KEY_MESSAGE => __('Code for :code already received by customer.', ['code' => $code]),
            ];
        }

        $pickup->update([
            'status' => PickupHelperService::STATUS_DELIVERED
        ]);
    }

}
