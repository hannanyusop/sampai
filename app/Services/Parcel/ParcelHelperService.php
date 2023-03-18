<?php

namespace App\Services\Parcel;

class ParcelHelperService
{

    //2 => 'Received By UTeM-Mel',
    //3 => 'Outbound To Drop Point',
    //4 => 'Inbound To Drop Point',
    //5 => 'Ready To Collect',
    //6 => 'Delivered',
    //7 => 'Return'

    const STATUS_REGISTERED = 1, STATUS_RECEIVED = 2, STATUS_OUTBOUND_TO_DROP_POINT = 3, STATUS_INBOUND_TO_DROP_POINT = 4;
    const STATUS_READY_TO_COLLECT = 5, STATUS_DELIVERED = 6, STATUS_RETURN = 7;


    public function statuses($status = null){

        $statuses = [
            self::STATUS_REGISTERED => __('Parcel registered into NUJ System'),
            self::STATUS_RECEIVED   => __('Received By NUJ'),
            self::STATUS_OUTBOUND_TO_DROP_POINT => __('Outbound To Drop Point Office'),
            self::STATUS_INBOUND_TO_DROP_POINT => __('Inbound To Drop Point'),
            self::STATUS_READY_TO_COLLECT => __('Ready To Collect'),
            self::STATUS_DELIVERED => __('Delivered'),
            self::STATUS_RETURN => __('Returned')
        ];

        return (is_null($status))? $status : $statuses[$status] ?? __('Invalid status');
    }

}
