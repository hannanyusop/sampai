<?php

namespace App\Services\Parcel;

use App\Domains\Auth\Models\Parcels;

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

        return (is_null($status))? $status : $statuses[$status] ?? __('Invalid status');
    }

    public static function whatappText(Parcels $parcel) :string{

        $text = __("Hello :name, your total bill for code:
        | *:pickup_code* |
        |*Price: :price*
        |*Qty: 1*
        |*Total Tax: :tax*
        |*Permit: B$:permit* |
        |Amount need to pay total= *:tax* |
        |Salam/Hi your parcel ready to be collected at *:pickup_point.* |
        |►*Ramadhan Business Hour*◄
        |♥ *Monday-Thursday & Saturday*
        |☼ 9.00 am - 5.30 pm |
        |♥ *Friday* |9am - 12pm
        |☼ 2pm - 5.30pm |
        |♥♥ Sunday & Public Holiday *CLOSED* |
        |Payment can be made by cash or Via online PREFERABLE (don't forget to screenshot of your receipt show to my staff pic of receipt.)
        |*Payment via cash below $20.* |*Vcard pyment $20 ke atas* |
        |VIA BIBD VCARD - 8687454
        |AWG ROSPPA |
        |Pasir Berakas Address:
        |No.13 Spg 311 , Kpg Lambak |Jln Pasir Berakas.
        |Sama simpang dengan Mudaseri Showroom ||Terima Kasih ☺", [
            'name' => $parcel?->user?->name,
            'pickup_code' => $parcel->pickup?->code,
            'price' => money_parse($parcel->price, 'BND'),
            'tax' => money_parse($parcel->tax, 'BND'),
            'permit' => money_parse($parcel->permit, 'BND'),
            'pickup_point' => $parcel->pickup?->dropPoint?->name,

        ]);

        return $text;
    }

}
