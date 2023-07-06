<?php

namespace App\Exports\Trip;

use App\Models\TripBatch;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BillingListExport implements FromArray, ShouldAutoSize, WithStyles, WithColumnWidths, WithEvents
{
    use Exportable;

    public $trip_batch;

    public function __construct(TripBatch $trip_batch){
        $this->trip_batch = $trip_batch;
    }

    public function array() : array
    {
        $array = [];

        $trip_batch = $this->trip_batch;

        $array[] = ['Trip ID', __("#:code", ['code' => $trip_batch->number])];
        $array[] = ['Date', reformatDatetime($trip_batch->date, 'd M, Y')];
        $array[] = [''];
        $array[] = [''];

        $array[] = ['No', 'Name', 'Phone Number', 'Code', 'Parcel Coding', 'Quantity', 'Price', 'Tax', 'Permit', 'Postage', 'Total', 'Location', 'Status'];

        foreach ($trip_batch->pickups as $key => $pickup){

            $coding = '';
            foreach($pickup->parcels as $parcel){
                $coding .=  __(':coding - :price', ['coding' => $parcel->coding, 'price' => displayPriceFormat($parcel->total_billing, '$')])." ~ ";
            }

            $array[] = [
                $key+1,
                $pickup->user->name,
                $pickup->user->phone_number,
                $pickup->code,
                $coding,
                $pickup->parcels->count(),
                displayPriceFormat($pickup->gross_price, '$'),
                displayPriceFormat($pickup->tax, '$'),
                displayPriceFormat($pickup->permit, '$'),
                displayPriceFormat($pickup->service_charge, '$'),
                displayPriceFormat($pickup->total, '$'),
                $pickup->dropPoint->code,
                $pickup->status_label,
            ];
        }

        return $array;
    }

    public function columnWidths(): array
    {
        return [
            'M' => 40,
        ];
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

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getStyle('M')->getAlignment()->setWrapText(true);
            },
        ];
    }
}
