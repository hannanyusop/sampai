<?php

namespace App\Services\Parcel;

use App\Models\Pickup;

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


    public static function statuses($status = null){

        $statuses = [
            self::STATUS_REGISTERED => __('Parcel registered into NUJ System'),
            self::STATUS_RECEIVED   => __('Received By NUJ'),
            self::STATUS_OUTBOUND_TO_DROP_POINT => __('Outbound To Drop Point Office'),
            self::STATUS_INBOUND_TO_DROP_POINT => __('Inbound To Drop Point'),
            self::STATUS_READY_TO_COLLECT => __('Ready To Collect'),
            self::STATUS_DELIVERED => __('Delivered'),
            self::STATUS_RETURN => __('Returned')
        ];

        return (is_null($status))? $statuses : $statuses[$status] ?? __('Invalid status');
    }

    public static function LBKWhatsappText(Pickup $pickup) :string{

        $text = __("Salam/Hi :name |Your parcel ready to be collected.|Pickup code:  :pickup_code . | For more detail please visit :link.", [
            'name' => \Str::upper($pickup?->user?->name),
            'pickup_code' => $pickup?->code,
            'total_billing' => displayPriceFormat($pickup->total, '$'),
            'price' => displayPriceFormat($pickup->price, '$'),
            'pickup_point' => $pickup->pickup?->dropPoint?->name,
            'tax' => displayPriceFormat($pickup->tax, '$'),
            'permit' => displayPriceFormat($pickup->permit, '$'),
            'total_parcel' => $pickup->parcels->count(),
            'link' => route('frontend.user.pickup.show', encrypt($pickup->id))
        ]);

        return $text;
    }

    public static function KLNWhatsappText(Pickup $pickup) :string{

        $text = __("Salam/Hi :name |Your parcel ready to be collected.|Pickup code:  :pickup_code . | For more detail please visit :link.", [
            'name' => \Str::upper($pickup?->user?->name),
            'pickup_code' => $pickup?->code,
            'total_billing' => displayPriceFormat($pickup->total, '$'),
            'price' => displayPriceFormat($pickup->price, '$'),
            'pickup_point' => $pickup->pickup?->dropPoint?->name,
            'tax' => displayPriceFormat($pickup->tax, '$'),
            'permit' => displayPriceFormat($pickup->permit, '$'),
            'total_parcel' => $pickup->parcels->count(),
            'link' => route('frontend.user.pickup.show', encrypt($pickup->id))
        ]);

        return $text;
    }


    public static function CalculateTax(float $price,float $currency_exchange,int $percent){

        $tax = $price  * $currency_exchange * $percent / 100;

        return ($tax - floor($tax) > 0)? floor($tax) + 1 : floor($tax);
    }

    public static function ConvertToBND(float $price, float $currency_exchange){

        //round up to nearest cent
        $converted =  $price / $currency_exchange;

        return ceil($converted * 10) / 10;

    }

}
