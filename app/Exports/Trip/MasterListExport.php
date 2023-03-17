<?php

namespace App\Exports\Trip;

use App\Domains\Auth\Models\Parcels;
use App\Domains\Auth\Models\Trip;
use Maatwebsite\Excel\Concerns\FromArray;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;

class MasterListExport implements FromArray, ShouldAutoSize, WithStyles
{
    public $trip;

    public function __construct(Trip $trip){
        $this->trip = $trip;
    }

    public function array() : array
    {
        $array = [];

        $trip = $this->trip;

        $array[] = ['Trip ID', __("#:code", ['code' => $trip->code]), ' ', 'Destination', $trip->destination->name];
        $array[] = ['Date', reformatDatetime($trip->date, 'd M, Y'), '', 'Destination Code', $trip->destination->code];
        $array[] = [''];
        $array[] = [''];
        $parcels = Parcels::where('trip_id', $this->trip->id)
            ->get();

        $array[] = ['No.','User ID', 'Tracking No','Receiver Name', 'Phone Number', 'Description', 'Price (RM)', 'Tax (BND $)', 'Status', 'Remark'];

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
