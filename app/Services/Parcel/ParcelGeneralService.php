<?php

namespace App\Services\Parcel;

use App\Domains\Auth\Models\Office;
use App\Domains\Auth\Models\Parcels;
use App\Domains\Auth\Models\Trip;
use App\Models\Pickup;
use App\Services\General\GeneralHelperService;
use App\Services\Pickup\PickupGeneralService;

class ParcelGeneralService
{

    public static function assignToPickup(Parcels $parcel, Trip $trip, Office $office){

        $servicePickup = PickupGeneralService::getPickupByUser($parcel->user, $trip, $office);

        $pickup = $servicePickup[GeneralHelperService::KEY_DATA];

        $parcel->pickup_id = $pickup->id;
        $parcel->save();

        $pickup->update([
            'total_tax' => $pickup->parcels()->sum('tax')
        ]);

        return [
            GeneralHelperService::KEY_STATUS  => GeneralHelperService::STATUS_SUCCESS,
            GeneralHelperService::KEY_MESSAGE => __('Successfully Assign')
        ];
    }

    public static function removeFromPickup(Parcels $parcel){

        $pickup = Pickup::find($parcel->pickup_id);

        if(!$pickup){
            return [
                GeneralHelperService::KEY_STATUS  => GeneralHelperService::STATUS_ERROR,
                GeneralHelperService::KEY_MESSAGE => __('Invalid data')
            ];
        }

        $parcel->lastTransaction()->delete();

        $parcel->update([
            'status' => ParcelHelperService::STATUS_RECEIVED,
            'pickup_id' => null
        ]);
    }
}
