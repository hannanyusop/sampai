<?php

namespace App\Exports\parcel;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportBulk implements FromArray
{
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        $rows = [];

        $rows[] = [
            'No.',
            'Name',
            'Phone',
            'tracking',
            'code',
            'Pickup Code',
            'Destination',

        ];

        foreach ($this->data as $key => $value) {
            $rows[] = [
                $key + 1,
                $value['name'],
                $value['phone'],
                $value['tracking'],
                $value['code'],
                $value['pickup'],
                $value['destination'],
            ];
        }
        return $rows;
    }
}
