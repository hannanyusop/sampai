<?php

namespace App\Exports\Trip;

use App\Domains\Auth\Models\Parcels;
use App\Domains\Auth\Models\Trip;
use App\Models\TripBatch;
use Maatwebsite\Excel\Concerns\FromArray;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;

class MasterListExport implements FromArray, ShouldAutoSize, WithStyles
{
    public $trip_batch;

    public function __construct(TripBatch $trip_batch){
        $this->trip_batch = $trip_batch;
    }

    public function array() : array
    {
        $array = [];

        $trip_batch = $this->trip_batch;

        $trip_ids = $this->trip_batch->trips()->pluck('id');

        $parcels = Parcels::whereHas('pickup', function($query) use ($trip_ids){
            $query->whereIn('trip_id', $trip_ids);
        })->get();



        $array[] = ['Trip ID', __("#:code", ['code' => $trip_batch->number])];
        $array[] = ['Date', reformatDatetime($trip_batch->date, 'd M, Y')];
        $array[] = [''];
        $array[] = [''];



        $array[] = ['No.','User ID', 'Tracking No','Receiver Name', 'Phone Number', 'Description','Destination', 'Price (RM)', 'Tax (BND $)', 'Status', 'Remark'];

        $ttl_tax = 0;
        $ttl_parcel = count($parcels);
        foreach ($parcels as $key => $parcel){
            $array[] = [
                $key+1,
                $parcel->user->id,
                $parcel->tracking_no,
                $parcel->receiver_name,
                $parcel->phone_number,
                $parcel->description,
                $parcel?->dropPoint?->name,
                $parcel->price ? number_format($parcel->price, '2', '.') : '0.00',
                $parcel->tax ? number_format($parcel->tax, '2', '.') : '0.00',
                $parcel->status_label,
                ''
            ];

            $ttl_tax+=$parcel->tax;

        }

        $array[] = ['', '', '', '', '','','',__('Total Tax::amount', ['amount' => displayPriceFormat($ttl_tax, '$')])];


        return $array;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            'A1'    => ['font' => ['bold' => true]],
            'D1'    => ['font' => ['bold' => true]],
            'A2'    => ['font' => ['bold' => true]],
            'D2'    => ['font' => ['bold' => true]],
        ];
    }
}
