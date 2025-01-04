<?php

namespace App\Exports\parcel;

use Maatwebsite\Excel\Concerns\FromArray;
class ExportBulkTemplate implements FromArray
{


    public function array(): array
    {
        $rows[] = [
            'tracking',
            'name',
            'phone',
            'Destination',
        ];
        return $rows;
    }

}
