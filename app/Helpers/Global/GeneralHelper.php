<?php

use App\Domains\Auth\Models\Parcels;
use App\Domains\Auth\Models\Office;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Models\Trip;
use App\Domains\Auth\Models\TripTransaction;
use App\Domains\Auth\Models\Subscribe;
use Illuminate\Support\Carbon;
use App\Domains\Auth\Models\ParcelTransaction;
use Mailgun\Mailgun;
use App\Domains\Auth\Models\Option;

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

if(!function_exists('getStatusByParcel')){

    function getStatusByParcel($tracking_no){

        $parcel = Parcels::where('tracking_no', $tracking_no)->first();

        if(!$parcel){
            return '<span class="badge badge-danger badge-pill">Pending</span>';
        }

        return '<span class="badge badge-success badge-pill">In Transit /Received</span>';
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

if(!function_exists('generateTripReceiveCode')){

    function generateTripReceiveCode(){

        do{
            $characters = '123456789ABCDEFGHIJKLMNPQRSTUVWXYZ';

            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < 6; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }

            $trip = Trip::where('receive_code', $randomString)->first();

        }while($trip);

        return $randomString;
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

if(!function_exists('getParcelStatus')){

    function getParcelStatus($status = null){

        #open -> close (ready to pick by runner) -> in transit -> arrive -> delivered
        $statuses = [
            0 => 'Received By UTeM-Mel',
            1 => 'Outbound To Drop Point',
            2 => 'Inbound To Drop Point',
            3 => 'Ready To Collect',
            4 => 'Delivered',
            5 => 'Return'
        ];

        return (is_null($status))? $statuses : $statuses[$status];

    }
}

if(!function_exists('getParcelStatusBadge')){

    function getParcelStatusBadge($status = null){

        $statuses = [
            0 => '<span class="badge badge-dot badge-dot-xs badge-secondary">Received by receiver office</span>',
            1 => '<span class="badge badge-dot badge-dot-xs badge-success" > Outbound To Drop Point </span>',
            2 => '<span class="badge badge-dot badge-dot-xs badge-success" > Inbound To Drop Point </span>',
            3 => '<span class="badge badge-dot badge-dot-xs badge-success" > Ready To Collect </span>',
            4 => '<span class="badge badge-dot badge-dot-xs badge-success" > Delivered </span>',
            5 => '<span class="badge badge-dot badge-dot-xs badge-danger" > Return </span>'
        ];

        return (is_null($status))? $statuses : $statuses[$status];

    }
}


if(!function_exists('getQr')){

    function getQr($tracking_no){

        return QRCode::url(route('admin.parcel.view',  ['tracking_no' => $tracking_no, 'uid' => auth()->user()->id]))
            ->setSize(5)
            ->setMargin(2)
            ->svg();
    }
}

if(!function_exists('getReceiveTripQr')){

    function getReceiveTripQr($code){

        return QRCode::url(route('admin.trip.receiveQR',  ['code' => $code]))
            ->setSize(5)
            ->setMargin(2)
            ->svg();
    }
}

if(!function_exists('dropPoints')){

    function dropPoints(){

        return Office::where('is_drop_point', 1)->get();
    }

}

if(!function_exists('parcelData')){

    function parcelData(){

        return [
            'all' => Parcels::all()->count(),
            'delivered' => Parcels::where('status', 4)->count(),
            'return' => Parcels::where('status', 5)->count(),
            'umel' => Parcels::where('status', 1)->count(),
            'runner' => Parcels::where('status', 2)->count(),
            'drop' => Parcels::where('status', 3)->count(),
            'staff' => User::where('type', '!=', 'user')->count(),
            'office' => Office::count(),
            'user' => User::where('type', 'user')->count(),

        ];
    }
}

if(!function_exists('getYear')){

    function getYear(){
        return range(2019, date('Y'));
    }
}

if (!function_exists('getMonthName')){

    function getMonthName(){

        return array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
    }
}

if(!function_exists('sendEmail')){

    function sendEmail(array $receiver, $subject, $content){

        try {

            foreach ($receiver as $to){

                $mgClient = Mailgun::create(env('MAILGUN_API'), 'https://api.mailgun.net');
                $domain = env('MAILGUN_API_URL');
                $params = array(
                    'from'    => 'no-reply@nuj.my',
                    'to'      => $to,
                    'subject' => $subject,
                    'text'    => $content
                );

                $mgClient->messages()->send($domain, $params);
            }


        }catch (Exception $exception){
        }


    }
}

if(!function_exists('dataUserDashboard')){

    function dataUserDashboard(){

        $parcel = Parcels::pluck('tracking_no');

        $pending = Subscribe::where('subscribes.user_id', auth()->user()->id)->whereNotIn('tracking_no', $parcel)->count();

        $transit = Subscribe::leftJoin('parcels', 'parcels.tracking_no', '=','subscribes.tracking_no')
            ->where('subscribes.user_id', auth()->user()->id)
            ->whereIn('status', [0,1,2])
            ->count();

        $arrive = Subscribe::leftJoin('parcels', 'parcels.tracking_no', '=','subscribes.tracking_no')
            ->where('subscribes.user_id', auth()->user()->id)
            ->whereIn('status', [3])
            ->count();

        $received = Subscribe::leftJoin('parcels', 'parcels.tracking_no', '=','subscribes.tracking_no')
            ->where('subscribes.user_id', auth()->user()->id)
            ->whereIn('status', [4])
            ->count();

        return [
            'pending' => $pending,
            'transit' => $transit,
            'arrive' => $arrive,
            'received' => $received
        ];
    }
}

if(!function_exists('getToyyibPayUrl')){

    function getToyyibPayUrl(){

        $is_sandbox = env('TOYYIB_SANDBOX', true);

        if($is_sandbox){

            return 'https://dev.toyyibpay.com';
        }else{

            return 'https://toyyibpay.com';
        }
    }

}

if(!function_exists('registrationEnabled')){

    function registrationEnabled(){
        return getOption('allow_registration', true);
    }
}

if(!function_exists('trackEnabled')){

    function trackEnabled(){
        return getOption('allow_tracking', true);
    }
}

if(!function_exists('paymentEnabled')){

    function paymentEnabled(){
        return getOption('payment_enabled', true);
    }
}

if(!function_exists('getMaxTrack')){

    function getMaxTrack(){
        return getOption('payment_limit_query', 5);
    }
}

if(!function_exists('getMinTopUp')){

    function getMinTopUp(){
        return getOption('payment_limit_top_up', 5);
    }
}

if(!function_exists('getCost')){

    function getCost(){
        return getOption('payment_cost', 0.30);
    }
}

if(!function_exists('displayPriceFormat')){

    function displayPriceFormat($price, $currency = 'RM'){

        return $currency.' '.number_format($price, 2, '.', '');
    }
}

if(!function_exists('getOption')){

    function getOption($name, $default = null){


        $option = Option::where('name', $name)->first();

        if(!$option){

           $option = Option::create([
                'name' => $name,
                'value' => $default
            ]);
        }

        return  $option->value;
    }
}




