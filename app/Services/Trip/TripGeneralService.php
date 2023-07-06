<?php

namespace App\Services\Trip;

use App\Domains\Auth\Models\Trip;
use App\Models\Pickup;
use App\Services\Parcel\ParcelHelperService;
use App\Services\Pickup\PickupHelperService;
use Illuminate\Support\Facades\DB;

class TripGeneralService
{
    //lambak / kilanas receive trip
    public static function ReceiveTrip($trip_id){

        $trip = Trip::where('id', $trip_id)
            ->where('status', ParcelHelperService::STATUS_OUTBOUND_TO_DROP_POINT)
            ->first();

        if (!$trip){
            return ['status' => 'error', 'message' => __('Trip not found')];
        }

        //start db transaction
        DB::beginTransaction();


        Pickup::where('trip_id', $trip_id)->update([
            'status' => PickupHelperService::STATUS_PICKUP_POINT_PROCESS
        ]);

        foreach ($trip->parcels as $parcel){

            $remark = "Item Processed at ".$trip->destination->name;

            addParcelTransaction($parcel->id, $remark);

            $parcel->status = ParcelHelperService::STATUS_INBOUND_TO_DROP_POINT;
            $parcel->save();
        }

        $trip->status = TripHelperService::STATUS_PICKUP_POINT_PROCESS;
        $trip->save();

        //commit db transaction
        DB::commit();
        return ['status' => 'success', 'message' => __('Trip received')];
    }

    //lambak / kilanas receive trip
    public static function ReleaseTrip($trip_id){

        $trip = Trip::where('id', $trip_id)
            ->first();

        if (!$trip){
            return ['status' => 'error', 'message' => __('Trip not found')];
        }

        if ($trip->status != TripHelperService::STATUS_PICKUP_POINT_PROCESS){
            return ['status' => 'error', 'message' => __('Trip not in correct status')];
        }

        //start db transaction
        DB::beginTransaction();

        Pickup::where('trip_id', $trip_id)->update([
            'status' => PickupHelperService::STATUS_READY_TO_DELIVER
        ]);

        foreach ($trip->parcels as $parcel){

            $remark = "Ready to collect at ".$trip->destination->name;

            addParcelTransaction($parcel->id, $remark);

            $parcel->status = ParcelHelperService::STATUS_READY_TO_COLLECT;
            $parcel->save();
        }

        $trip->status = TripHelperService::STATUS_ARRIVED;
        $trip->save();

        //commit db transaction
        DB::commit();
        return ['status' => 'success', 'message' => __('Trip received')];
    }
}
