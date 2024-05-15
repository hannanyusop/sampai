<?php

namespace App\Exports\Trip;

use App\Domains\Auth\Models\Parcels;
use App\Domains\Auth\Models\Trip;
use App\Models\Pickup;
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

class WhatsappBotExport implements FromArray, ShouldAutoSize, WithStyles, WithColumnWidths, WithEvents
{
    use Exportable;

    public $trip_batch;
    public $trip_id = null;

    public function __construct(TripBatch $trip_batch, $trip_id = null){
        $this->trip_batch = $trip_batch;
        $this->trip_id    = $trip_id;
    }

    public function array() : array
    {
        $array = [];

        $trip_batch = $this->trip_batch;

        $trip_batch = TripBatch::find($trip_batch->id);

        $array[] = ['Trip ID', __("#:code", ['code' => $trip_batch->number])];
        $array[] = ['Date', reformatDatetime($trip_batch->date, 'd M, Y')];
        $array[] = [''];
        $array[] = [''];

        $array[] = ['No.','User ID','Name', 'Code','Destination', 'Price ($)','Status', 'Remark', 'Phone Number', 'Message'];


        $pickups = Pickup::with(['user', 'dropPoint'])->whereHas('trip', function($query) use ($trip_batch){
            $query->where('trip_batch_id', $trip_batch->id);
        })->when($this->trip_id, function ($query) {
            $query->where('trip_id', $this->trip_id);
        })->get();

        foreach ($pickups as $key => $pickup){
            $array[] = [
                $key+1,
                $pickup?->user->id,
                $pickup?->user->name,
                $pickup?->code,
                $pickup?->dropPoint?->name,
                displayPriceFormat($pickup->total, '$'),
                $pickup->status_label,
                '',
                $pickup?->user?->phone_number,
                ($pickup->dropPoint->code == "L") ? ParcelHelperService::LBKWhatsappText($pickup) : ParcelHelperService::KLNWhatsappText($pickup)
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
