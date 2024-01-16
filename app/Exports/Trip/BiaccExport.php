<?php

namespace App\Exports\Trip;

use App\Domains\Auth\Models\Parcels;
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

class BiaccExport implements FromArray, ShouldAutoSize, WithStyles, WithColumnWidths, WithEvents
{
    use Exportable;

    public $trip_batch;

    public function __construct(TripBatch $trip_batch)
    {
        $this->trip_batch = $trip_batch;
    }

    public function array(): array
    {
         sleep(5);
        $array = [];

        $trip_batch = $this->trip_batch;

        $trip_ids = $this->trip_batch->trips()->pluck('id');

        $parcels = Parcels::with(['user', 'pickup', 'pickup.dropPoint'])
            ->whereHas('pickup', function ($query) use ($trip_ids) {
                $query->whereIn('trip_id', $trip_ids);
            })->get();


        $array[] = ['Trip ID', __("#:code", ['code' => $trip_batch->number])];
        $array[] = ['Date', reformatDatetime($trip_batch->date, 'd M, Y')];
        $array[] = [''];
        $array[] = [''];


        $array[] = ['No.', 'User ID', 'Tracking No', 'Code', 'Guni', 'Receiver Name', 'Description', 'Destination', 'Price (RM)','Invoice'];

        $ttl_tax = 0;
        $ttl_parcel = count($parcels);
        foreach ($parcels as $key => $parcel) {
            $array[] = [
                $key + 1,
                $parcel?->user->id,
                $parcel?->tracking_no,
                $parcel?->coding,
                $parcel?->guni,
                $parcel?->receiver_name,
                $parcel?->description,
                $parcel?->dropPoint?->name,
                $parcel->price ? number_format($parcel->price, '2', '.') : '0.00',
                route('frontend.user.parcel.download',encrypt($parcel->id))
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
            'A1' => ['font' => ['bold' => true]],
            'D1' => ['font' => ['bold' => true]],
            'A2' => ['font' => ['bold' => true]],
            'D2' => ['font' => ['bold' => true]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('M')->getAlignment()->setWrapText(true);
            },
        ];
    }
}
