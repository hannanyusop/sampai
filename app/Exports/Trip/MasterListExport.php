<?php

namespace App\Exports\Trip;

use App\Domains\Auth\Models\Parcels;
use App\Models\TripBatch;
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

class MasterListExport implements FromQuery, WithMapping, WithHeadings, WithCustomChunkSize, ShouldAutoSize, WithStyles, WithColumnWidths, WithEvents
{
    use Exportable;

    protected $rowNumber = 0;
    protected $totalTax = 0;

    public $trip_batch;

    public function __construct(TripBatch $trip_batch){
        $this->trip_batch = $trip_batch;
    }

    public function query()
    {
        $trip_ids = $this->trip_batch->trips()->select('trips.id');

        return Parcels::with([
            'user' => fn ($query) => $query->without(['roles', 'permissions']),
            'pickup.dropPoint', 'dropPoint',
        ])
            ->whereHas('pickup', function($query) use ($trip_ids){
                $query->whereIn('trip_id', $trip_ids);
            })->orderBy('id');
    }

    public function headings(): array
    {
        $trip_batch = $this->trip_batch;
        $this->rowNumber = 0;
        $this->totalTax = 0;
        return [
            ['Trip ID', __("#:code", ['code' => $trip_batch->number])],
            ['Date', reformatDatetime($trip_batch->date, 'd M, Y')],
            [''],
            [''],
            ['No.','User ID', 'Tracking No', 'Code', 'Guni', 'Receiver Name', 'Phone Number', 'Description', 'Category', 'Destination', 'Price (RM)','Percentage (%)', 'Tax (BND $)', 'Service Charge ($)', 'Status', 'Remark', 'Phone Number', 'Message'],
        ];
    }

    public function chunkSize(): int
    {
        return 200;
    }

    public function map($parcel): array
    {
        $category_to_string = '';
        foreach ($parcel->cat as $category_title){
            $category_to_string .= $category_title . ',';
            $category_to_string .= "\n";
        }

        $this->totalTax += $parcel->tax;
        return [
            ++$this->rowNumber,
            $parcel?->user?->id,
            $parcel?->tracking_no,
            $parcel?->coding,
            $parcel?->guni,
            $parcel?->receiver_name,
            $parcel?->phone_number,
            $parcel?->description,
            $category_to_string,
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
                $event->sheet->append([['', '', '', '', '', '', '', __('Total Tax::amount', ['amount' => displayPriceFormat($this->totalTax, '$')])]]);
                $event->sheet->getStyle('M')->getAlignment()->setWrapText(true);
            },
        ];
    }
}
