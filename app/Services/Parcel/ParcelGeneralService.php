<?php

namespace App\Services\Parcel;

use App\Domains\Auth\Http\Requests\Backend\Parcel\CompleteRequest;
use App\Domains\Auth\Models\Office;
use App\Domains\Auth\Models\Parcels;
use App\Domains\Auth\Models\Trip;
use App\Models\Pickup;
use App\Models\TripBatch;
use App\Models\UnregisteredParcel;
use App\Services\General\GeneralHelperService;
use App\Services\Pickup\PickupGeneralService;
use App\Services\Role\RoleHelperService;
use App\Services\Trip\TripHelperService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ParcelGeneralService
{

    public static function query()
    {
        return Parcels::with('transactions')->when(!auth()->user()->can('staff.distributor') || !auth()->user()->can('staff.runner'), function ($q){
//            $q->where('office_id', auth()->user()->office_id);
//                ->whereIn('parcels.status', [3,4,5]);

        })->when(!auth()->user()->hasAnyRole([RoleHelperService::ROLE_ADMIN, RoleHelperService::ROLE_STAFF]), function ($q){
                $q->where('user_id', auth()->user()->id);
        });
    }

    //customer save new parcel
    public static function store(Request $request)
    {

        try {

            $exists = Parcels::where('tracking_no', strtoupper($request->tracking_no))->first();

            if($exists){
                return ['status' => 'error', 'message' => 'Tracking no '. strtoupper($request->tracking_no). ' already exist.', 'data' => null, 'code' => 500];
            }

            if (!$request->hasFile('invoice_url')){
                return ['status' => 'error', 'message' => 'Please attach invoice.', 'data' => null, 'code' => 500];
            }

            $parcel = new Parcels();
            $parcel->user_id       = auth()->user()->id;
            $parcel->tracking_no   = strtoupper($request->tracking_no);
            $parcel->status        = ParcelHelperService::STATUS_REGISTERED;
            $parcel->receiver_name = strtoupper($request->receiver_name);
            $parcel->phone_number  = $request->phone_number;
            $parcel->description   = $request->description;
            $parcel->price         = $request->price;
            $parcel->quantity      = $request->quantity;
            $parcel->order_origin  = $request->order_origin;
            $parcel->office_id     = $request->office_id;

            if ($request->hasFile('invoice_url')){
                $file                  = Storage::disk('public')->put('invoice', $request->file('invoice_url'));
                $parcel->invoice_url   = $file;
            }

            $unregistered = UnregisteredParcel::where([
                'tracking_no' => $request->tracking_no,
                'parcel_id' => null
            ])->first();

            if($unregistered){
                $unregistered->parcel_id = $parcel->id;
                $unregistered->save();
            }

            $parcel->save();

            addParcelTransaction($parcel->id, ParcelHelperService::statuses(ParcelHelperService::STATUS_REGISTERED));
            return ['status' => 'success', 'message' => 'Parcel inserted with id: '.$parcel->id, 'data' => $parcel, 'code' => 200];

        }catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage(), 'data' => null, 'code' => 500];
        }

    }

    public static function update(Request $request, Parcels $parcel)
    {

        $parcel = ParcelGeneralService::query()->find($parcel->id);

        if (!$parcel) {
           return ['status' => 'error', 'message' => 'Parcel not found!', 'data' => null, 'code' => 404];
        }

        try {

            DB::beginTransaction();

            $old_invoice_url = $parcel->invoice_url;

            if ($request->hasFile('invoice_url')){

                $file                  = Storage::disk('public')->put('invoice', $request->file('invoice_url'));
                $parcel->invoice_url   = $file;
            }

            $parcel->receiver_name = strtoupper($request->receiver_name);
            $parcel->phone_number = $request->phone_number;
            $parcel->tracking_no = strtoupper($request->tracking_no);
            $parcel->description = strtoupper($request->description);
            $parcel->quantity = $request->quantity;
            $parcel->price = $request->price;
            $parcel->office_id  = $request->office_id;
            $parcel->save();

            DB::commit();

            if ($request->hasFile('invoice_url') && Storage::disk('public')->exists($old_invoice_url)){
                Storage::disk('public')->delete($old_invoice_url);
            }

            return ['status' => 'success', 'message' => 'Parcel updated', 'data' => $parcel, 'code' => 200];

        }Catch(\Exception $exception){

            DB::rollBack();

            if ($request->hasFile('invoice_url') && Storage::disk('public')->exists($file)){
                Storage::disk('public')->delete($file);
            }

            return ['status' => 'error', 'message' => $exception->getMessage(), 'data' => null, 'code' => 500];
        }

    }

    public static function insertableParcel($tracking_no, TripBatch $tripBatch){

        $parcel =  self::query()->where([
            'tracking_no' => $tracking_no,
            'status' => ParcelHelperService::STATUS_REGISTERED,
        ])->first();

        if (!$parcel) {
            return [
                GeneralHelperService::KEY_STATUS  => GeneralHelperService::STATUS_ERROR,
                GeneralHelperService::KEY_MESSAGE => __('No parcel found for :tracking_no', ['tracking_no' => $tracking_no])
            ];
        }

        if ($parcel->pickup_id != null) {
            return [
                GeneralHelperService::KEY_STATUS  => GeneralHelperService::STATUS_ERROR,
                GeneralHelperService::KEY_MESSAGE => __('Parcel :tracking_no already assigned to Trip : :pickup_id', ['pickup_id' => $parcel->trip?->batch?->number, 'tracking_no' => $tracking_no])
            ];
        }

        $trip = Trip::where([
            'trip_batch_id' => $tripBatch->id,
            'destination_id' => $parcel->office_id
        ])->first();

        if (!$trip){

            return [
                GeneralHelperService::KEY_STATUS  => GeneralHelperService::STATUS_ERROR,
                GeneralHelperService::KEY_MESSAGE => __('No available destination found for :tracking_no', ['tracking_no' => $tracking_no])
            ];
        }

        if ($trip->status != TripHelperService::STATUS_PENDING){

            return [
                GeneralHelperService::KEY_STATUS  => GeneralHelperService::STATUS_ERROR,
                GeneralHelperService::KEY_MESSAGE => __('Trip already in status :status', ['status' => $trip->status_label])
            ];
        }

        return [
            GeneralHelperService::KEY_STATUS  => GeneralHelperService::STATUS_SUCCESS,
            GeneralHelperService::KEY_MESSAGE => __(''),
            GeneralHelperService::KEY_DATA => $parcel
        ];
    }

    public static function assignToTripBatch($trackin_no,TripBatch $tripBatch){

        $parcel = Parcels::where('tracking_no', $trackin_no)
            ->first();

        if (!$parcel) {
            return [
                GeneralHelperService::KEY_STATUS  => GeneralHelperService::STATUS_ERROR,
                GeneralHelperService::KEY_MESSAGE => __('No parcel found for :tracking_no', ['tracking_no' => $trackin_no])
            ];
        }

        if($parcel->status != ParcelHelperService::STATUS_REGISTERED){
            return [
                GeneralHelperService::KEY_STATUS  => GeneralHelperService::STATUS_ERROR,
                GeneralHelperService::KEY_MESSAGE => __('Fail to assign parcel with status :  :status', ['status' => ParcelHelperService::statuses($parcel->status)])
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

        $parcel->code = self::GenerateCode($pickup, $parcel);
        $parcel->pickup_id = $pickup->id;
        $parcel->save();


        addParcelTransaction($parcel->id, "Parcel received by NUJ and assigned to trip $trip->code");

        return [
            GeneralHelperService::KEY_STATUS  => GeneralHelperService::STATUS_SUCCESS,
            GeneralHelperService::KEY_MESSAGE => __('Successfully Assign'),
            GeneralHelperService::KEY_DATA => $parcel
        ];
    }

    public static function GenerateCode(Pickup $pickup, Parcels $parcel){

        $start = 0;
        do{

            $start++;
            $parcel = Parcels::where([
                'code'      => $start,
                'pickup_id' => $pickup->id,
                'status'    => ParcelHelperService::STATUS_REGISTERED,
            ])
                ->first();

        }while($parcel);

        return $start;
    }

    public static function undoTripBatch(TripBatch $tripBatch, $parcel_id){

        $parcel = Parcels::where([
            'id' => $parcel_id,
        ])->first();

        if (!$parcel || $parcel->pickup_id == null) {
            return [
                GeneralHelperService::KEY_STATUS  => GeneralHelperService::STATUS_ERROR,
                GeneralHelperService::KEY_MESSAGE => __('Invalid data')
            ];
        }

        return self::removeFromPickup($parcel);
    }

    public static function assignToPickup(Parcels $parcel, Trip $trip, Office $office){

        if ($trip->status != TripHelperService::STATUS_PENDING){

            return [
                GeneralHelperService::KEY_STATUS  => GeneralHelperService::STATUS_ERROR,
                GeneralHelperService::KEY_MESSAGE => __('Trip already in status :status', ['status' => $trip->status_label])
            ];
        }

        $servicePickup = PickupGeneralService::getPickupByUser($parcel->user, $trip, $office);

        $pickup = $servicePickup[GeneralHelperService::KEY_DATA];

        $parcel->pickup_id = $pickup->id;
        $parcel->save();


        addParcelTransaction($parcel->id, "Parcel received by NUJ and assigned to trip $trip->code");

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

        if ($parcel->trip->status != TripHelperService::STATUS_PENDING){

            return [
                GeneralHelperService::KEY_STATUS  => GeneralHelperService::STATUS_ERROR,
                GeneralHelperService::KEY_MESSAGE => __('Trip already in status :status', ['status' => $parcel->trip->status_label])
            ];
        }

        $parcel->lastTransaction()->delete();

        $parcel->update([
            'status'    => ParcelHelperService::STATUS_REGISTERED,
            'pickup_id' => null,
            'code'      => null
        ]);

        return [
            GeneralHelperService::KEY_STATUS  => GeneralHelperService::STATUS_SUCCESS,
            GeneralHelperService::KEY_MESSAGE => __('Successfully removed')
        ];
    }

    public static function deliver(Parcels $parcel,$pickup_name){


        $parcel->receiver_name = $pickup_name;
        $parcel->pickup_info = "";
        $parcel->status = ParcelHelperService::STATUS_DELIVERED;
        $parcel->save();

        $remark = "Parcel delivered to ".$pickup_name;

        addParcelTransaction($parcel->id, $remark);
        return true;
    }
}
