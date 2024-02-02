<?php

namespace App\Services\Pickup;

use App\Domains\Auth\Models\Office;
use App\Domains\Auth\Models\Trip;
use App\Domains\Auth\Models\User;
use App\Models\Pickup;
use App\Services\General\GeneralHelperService;
use App\Services\Parcel\ParcelGeneralService;
use App\Services\Sales\DailySaleGeneralService;
use Illuminate\Http\Request;

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
        $next_id = ($last)? $last->id+1-10100 : 1;

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


    public static function deliver(Request $request, Pickup $pickup){

        try {
            \DB::beginTransaction();

            $get_office = DailySaleGeneralService::create($pickup->office_id);

            if($get_office['status'] == 'error'){
                return $get_office;
            }

            $daily_sale = $get_office['data'];

            $pickup->update([
                'daily_sale_id' => $daily_sale->id,
                'status'           => PickupHelperService::STATUS_DELIVERED,
                'pickup_name'      => $request->pickup_name,
                'pickup_datetime'  => now(),
                'serve_by'         => auth()->user()->id,
                'payment_method'   => $request->payment_method,
                'payment_status'   => PickupHelperService::PAYMENT_STATUS_PAID,
                'cash_received'    => $request->total_payment,
                'bank_transfer_received' => $request->total_payment,
                'total_payment'    => $request->total_payment,
                'prof_of_delivery' => $request->prof_of_delivery,
                'total_price'      => $request->total_price,
            ]);

            $daily_sale->total_sales += $request->total_payment;
            $daily_sale->expected_sales += $request->total_price;

            $daily_sale->cash += $request->cash_received;
            $daily_sale->bank_transfer += $request->bank_transfer_received;

            $daily_sale->save();

            foreach ($pickup->parcels as $parcel){
                ParcelGeneralService::deliver($parcel , $request->pickup_name);
            }

            \DB::commit();

            return [
                GeneralHelperService::KEY_STATUS  => GeneralHelperService::STATUS_SUCCESS,
                GeneralHelperService::KEY_MESSAGE => __('Pickup delivered successfully.'),
                GeneralHelperService::KEY_DATA    => $pickup
            ];

        }catch (\Exception $e){
            return [
                GeneralHelperService::KEY_STATUS  => GeneralHelperService::STATUS_ERROR,
                GeneralHelperService::KEY_MESSAGE => $e->getMessage(),
                'code'                             => $e->getCode(),
            ];
        }
    }

}
