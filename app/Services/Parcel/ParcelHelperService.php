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

        $text = __("Salam/Hi your parcel ready to be collected.|Pickup code:  :pickup_code . | For more detail please visit :link.", [
            'name' => $pickup?->user?->name,
            'pickup_code' => $pickup->pickup?->code,
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


//        $parcel_text = "";
//
//        foreach ($pickup->parcels as $parcel) {
//            $parcel_text .= " *".$parcel->tracking_no."* *".displayPriceFormat($parcel->total_billing, '$')."* *".$parcel->tax."* *".$parcel->permit."* *".$parcel->total."* ";
//        }

//        $text = __("Asalamualaikum..item abiskita bro/sis boleh sudah di collect di alamat niNo.115A kg. kilanas, jln tutong.Belakang restaurant belakang rumah buat kacahttps://www.google.com/maps/place/4%C2%B052'42.9%22N+114%C2%B051'29.7%22E For assitant pls text
//+6738868109/8815404
//-Business hour
//*Monday n Thursday CLOSE
//
//OPEN:
//• Tuesday n wednesday 10.30am-6pm
//• Friday 10.30am-12pm & 2pm-6pm
//• Sat n Sun 10.30am-6pm
//
//Pp/s plz recheck Nama n Tracking No yang betul sblum sign dan meninggalkn kaunter.
//
//Bagi yang mengambil parcel , diminta untuk FOWARD CODE yang diberikan terlebih awal sebelum mengambil :
//
//CODE: :pickup_code  :total_billing
//TOTAL PARCEL: :total_parcel
//NAMA: :name
//PRICE: :total_billing
//For more detail please visit :link
//
//• Parcel akan disediakan di kaunter luar.
//• Pastikan biskita SIGN bagi pengesahan
//Abiskita pastikan AMOUNT yg diberikan.
//
//►PARCEL & BOOKING COLLECTION◄
//
//►Sebarang Transaksi BIBD/BAIDURI hendaklah $10.00 ke atas .
//
//►Kerjasama abiskita untuk memaklumkan resit pembayaran, hendaklah dimaklumkan kpd staff utk d skrinShot
//Bibd Acc 00001010104774
//Vcard No 8815404
//
//Terima kasih
//
//Terima kasih di atas kerjasama abiskita", [
//            'name' => $pickup?->user?->name,
//            'pickup_code' => $pickup->pickup?->code,
//            'total_billing' => money_parse($pickup->total, 'BND'),
//            'pickup_point' => $pickup?->dropPoint?->name,
//            'total_parcel' => $pickup->parcels->count(),
//            'link' => route('frontend.user.pickup.show', encrypt($pickup->id))
//        ]);

        $text = __("Salam/Hi your parcel ready to be collected.|Pickup code:  :pickup_code . | For more detail please visit :link.", [
            'name' => $pickup?->user?->name,
            'pickup_code' => $pickup->pickup?->code,
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
