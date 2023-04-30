<?php

namespace App\Services\TripBatch;

use App\Domains\Auth\Models\Trip;
use App\Models\TripBatch;
use App\Services\Parcel\ParcelHelperService;
use App\Services\Trip\TripHelperService;

class TripBatchGeneralService
{

    public static function query(){

        return TripBatch::query();
    }

    public static function getByStatus($statuses = []){
        return self::query()
            ->whereHas('trips', fn($q) => $q->whereIn('status', $statuses));
    }

    public static function pick($trip_batch_id){

        if(!auth()->user()->can('staff.runner')){
            return ['status' => 'error', 'message' => __('Permission Denied')];
        }

        $trip_batch = TripBatchGeneralService::getByStatus([TripHelperService::STATUS_CLOSED])->findOrFail($trip_batch_id);

        foreach ($trip_batch->parcels as $parcel){

            $remark = "In transit to ".$parcel->pickup->dropPoint->name.". RIDER:".auth()->user()->name;

            addParcelTransaction($parcel->id, $remark);

            $parcel->status = ParcelHelperService::STATUS_OUTBOUND_TO_DROP_POINT;
            $parcel->save();
        }

        Trip::where('trip_batch_id', $trip_batch_id)->update([
            'status' => TripHelperService::STATUS_IN_TRANSIT,
            'runner_id' => auth()->user()->id,
        ]);

        return ['status' => 'success', 'message' => __('Trip picked')];
    }

}
