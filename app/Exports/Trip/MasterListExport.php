<?php

namespace App\Exports\Trip;

use App\Domains\Auth\Models\Parcels;
use App\Domains\Auth\Models\Trip;
use App\Models\TripBatch;
use App\Services\Parcel\ParcelHelperService;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

class MasterListExport implements FromArray, ShouldAutoSize, WithStyles, WithColumnWidths, WithEvents
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

        $trip_ids = $this->trip_batch->trips()->pluck('id');

        $parcels = Parcels::with(['user', 'pickup', 'pickup.dropPoint'])
            ->whereHas('pickup', function($query) use ($trip_ids){
                $query->whereIn('trip_id', $trip_ids);
            })->get();



        $array[] = ['Trip ID', __("#:code", ['code' => $trip_batch->number])];
        $array[] = ['Date', reformatDatetime($trip_batch->date, 'd M, Y')];
        $array[] = [''];
        $array[] = [''];



        $array[] = ['No.','User ID', 'Tracking No', 'Code', 'Guni', 'Receiver Name', 'Phone Number', 'Description','Destination', 'Price (RM)','Percentage (%)', 'Tax (BND $)', 'Service Charge ($)', 'Status', 'Remark', 'Phone Number', 'Message'];

        $ttl_tax = 0;
        $ttl_parcel = count($parcels);
        foreach ($parcels as $key => $parcel){
            $array[] = [
                $key+1,
                $parcel?->user->id,
                $parcel?->tracking_no,
                $parcel?->coding,
                $parcel?->guni,
                $parcel?->receiver_name,
                $parcel?->phone_number,
                $parcel?->description,
                $parcel?->dropPoint?->name,
                $parcel->price ? number_format($parcel->price, '2', '.') : '0.00',
                $parcel->percentage ? number_format($parcel->percentage, '2', '.') : '0.00',
                $parcel->tax ? number_format($parcel->tax, '2', '.') : '0.00',
                $parcel->service_charge ? number_format($parcel->service_charge, '2', '.') : '0.00',
                $parcel->status_label,
                '',
                $parcel?->user?->phone_number,
                ""
            ];

            $ttl_tax+=$parcel->tax;

        }

        $array[] = ['', '', '', '', '','','',__('Total Tax::amount', ['amount' => displayPriceFormat($ttl_tax, '$')])];


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
