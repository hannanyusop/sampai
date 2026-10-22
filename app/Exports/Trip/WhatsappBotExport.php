<?php

namespace App\Exports\Trip;

use App\Domains\Auth\Models\Office;
use App\Models\Pickup;
use App\Models\TripBatch;
use App\Services\Parcel\ParcelHelperService;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithCustomChunkSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

class WhatsappBotExport implements FromQuery, WithMapping, WithHeadings, WithCustomChunkSize, ShouldAutoSize, WithStyles, WithColumnWidths, WithEvents
{
    use Exportable;

    protected $rowNumber = 0;
    protected $offices;

    public $trip_batch;
    public $trip_id = null;

    public function __construct(TripBatch $trip_batch, $trip_id = null){
        $this->trip_batch = $trip_batch;
        $this->trip_id    = $trip_id;
    }

    public function query()
    {
        return Pickup::with([
            'user' => fn ($query) => $query->without(['roles', 'permissions']),
            'dropPoint',
        ])->whereHas('trip', function($query){
            $query->where('trip_batch_id', $this->trip_batch->id);
        })->when($this->trip_id, function ($query) {
            $query->where('trip_id', $this->trip_id);
        })->orderBy('id');
    }

    public function headings(): array
    {
        $trip_batch = $this->trip_batch;
        $this->rowNumber = 0;
        return [
            ['Trip ID', __("#:code", ['code' => $trip_batch->number])],
            ['Date', reformatDatetime($trip_batch->date, 'd M, Y')],
            [''],
            [''],
            ['No.','User ID','Name', 'Code','Destination', 'Price ($)','Status', 'Remark', 'Phone Number', 'Message'],
        ];
    }

    public function chunkSize(): int
    {
        return 200;
    }

    public function map($pickup): array
    {
        if ($this->offices === null) {
        $this->offices = Office::pluck('whatsapp_template', 'id')->toArray();
        }
        return [
            ++$this->rowNumber,
            $pickup?->user?->id,
            $pickup?->user?->name,
            $pickup?->code,
            $pickup?->dropPoint?->name,
            displayPriceFormat($pickup->total, '$'),
            $pickup->status_label,
            '',
            $pickup?->user?->phone_number,
            ParcelHelperService::GeneralWhatsappText($pickup, $this->offices)
        ];
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
