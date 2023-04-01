<?php

namespace App\Services\Parcel;

use App\Domains\Auth\Models\Office;
use App\Domains\Auth\Models\Parcels;
use App\Domains\Auth\Models\Trip;
use App\Models\Pickup;
use App\Models\TripBatch;
use App\Services\General\GeneralHelperService;
use App\Services\Pickup\PickupGeneralService;

class ParcelGeneralService
{


    public static function assignToTripBatch($trackin_no,TripBatch $tripBatch){

        $parcel = Parcels::where('tracking_no', $trackin_no)->first();

        if (!$parcel) {
            return [
                GeneralHelperService::KEY_STATUS  => GeneralHelperService::STATUS_ERROR,
                GeneralHelperService::KEY_MESSAGE => __('No parcel found for :tracking_no', ['tracking_no' => $trackin_no])
            ];
        }

        $trip = Trip::where([
            'trip_batch_id' => $tripBatch->id,
            'destination_id' => $parcel->office_id
        ])->first();

        if (!$trip) {
            return [
                GeneralHelperService::KEY_STATUS  => GeneralHelperService::STATUS_ERROR,
                GeneralHelperService::KEY_MESSAGE => __('No trip found for :tracking_no', ['tracking_no' => $trackin_no])
            ];
        }

        $servicePickup = PickupGeneralService::getPickupByUser($parcel->user, $trip, $trip->office);

        $pickup = $servicePickup[GeneralHelperService::KEY_DATA];

        $parcel->pickup_id = $pickup->id;
        $parcel->save();


        addParcelTransaction($parcel->id, "Parcel assigned to trip $trip->code");

        return [
            GeneralHelperService::KEY_STATUS  => GeneralHelperService::STATUS_SUCCESS,
            GeneralHelperService::KEY_MESSAGE => __('Successfully Assign')
        ];
    }

    public static function undoTripBatch(TripBatch $tripBatch, $parcel_id){

        $parcel = Parcels::find($parcel_id);

        if (!$parcel || $parcel->pickup_id == null) {
            return [
                GeneralHelperService::KEY_STATUS  => GeneralHelperService::STATUS_ERROR,
                GeneralHelperService::KEY_MESSAGE => __('Invalid data')
            ];
        }

        return self::removeFromPickup($parcel);
    }

    public static function assignToPickup(Parcels $parcel, Trip $trip, Office $office){

        $servicePickup = PickupGeneralService::getPickupByUser($parcel->user, $trip, $office);

        $pickup = $servicePickup[GeneralHelperService::KEY_DATA];

        $parcel->pickup_id = $pickup->id;
        $parcel->save();


        addParcelTransaction($parcel->id, "Parcel assigned to trip $trip->code");

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

        return [
            GeneralHelperService::KEY_STATUS  => GeneralHelperService::STATUS_SUCCESS,
            GeneralHelperService::KEY_MESSAGE => __('Successfully removed')
        ];
    }
}
