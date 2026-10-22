<?php

namespace App\Imports\Parcel;

use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class BulkPreviewImport implements WithMultipleSheets, WithChunkReading
{
    public $sheet;

    public function __construct()
    {
        $this->sheet = new BulkPreviewSheet;
    }

    public function sheets(): array
    {
        // The existing preview uses only the first worksheet.
        return [0 => $this->sheet];
    }

    public function chunkSize(): int
    {
        return 100;
    }
}
