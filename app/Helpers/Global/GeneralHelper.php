<?php

use App\Domains\Auth\Models\Parcels;
use App\Domains\Auth\Models\Office;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Models\Trip;
use App\Domains\Auth\Models\TripTransaction;
use App\Domains\Auth\Models\Subscribe;
use Illuminate\Support\Carbon;
use App\Domains\Auth\Models\ParcelTransaction;

if (! function_exists('appName')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function appName()
    {
        return config('app.name', 'Laravel Boilerplate');
    }
}

if (! function_exists('carbon')) {
    /**
     * Create a new Carbon instance from a time.
     *
     * @param $time
     *
     * @return Carbon
     * @throws Exception
     */
    function carbon($time)
    {
        return new Carbon($time);
    }
}

if (! function_exists('homeRoute')) {
    /**
     * Return the route to the "home" page depending on authentication/authorization status.
     *
     * @return string
     */
    function homeRoute()
    {
        if (auth()->check()) {
            if (auth()->user()->isAdmin()) {
                return 'admin.dashboard';
            }

            if (auth()->user()->isUser()) {
                return 'frontend.user.dashboard';
            }
        }

        return 'frontend.index';
    }
}

if(!function_exists('getParcelStatus')){

    function getParcelStatus($tracking_no){

        $parcel = Parcels::where('tracking_no', $tracking_no)->first();

        if(!$parcel){
            return '<span class="badge badge-danger badge-pill">Not Found</span>';
        }

        return '<span class="badge badge-success badge-pill">In Transit</span>';
    }
}

if(!function_exists('generateTripCode')){

    function generateTripCode($office_id, $date){

        $trips = Trip::where('destination_id', $office_id)
//            ->whereDate('date', $date)
            ->get();

        $office = Office::find($office_id);

        $x = $trips->count()+1;

        return $office->code."/".date('Y-m-d')."/".$x;
    }
}

if(!function_exists('reformatDatetime')){

    function reformatDatetime($str, $format = 'd-m-Y , h:i:s A'){

        return Carbon::parse($str)->format($format);
    }
}

if(!function_exists('addParcelTransaction')){

    function addParcelTransaction($parcel_id, $remark){

        $parcel = Parcels::find($parcel_id);

        if(!$parcel){
            return false;
        }

        $transaction = new ParcelTransaction();

        $transaction->user_id = auth()->user()->id;
        $transaction->parcel_id = $parcel_id;
        $transaction->remark = $remark;
        $transaction->save();

        return true;
    }

}
