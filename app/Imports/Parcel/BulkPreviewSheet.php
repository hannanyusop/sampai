<?php

namespace App\Imports\Parcel;

use App\Services\Parcel\ParcelHelperService;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithLimit;

class BulkPreviewSheet implements ToCollection, WithLimit
{
    public const MAX_ROWS = 500;

    public $header;
    public $rows = [];

    public function limit(): int
    {
        // Read one extra data row to reject oversized files without scheduling every chunk.
        return self::MAX_ROWS + 2;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $row = $row instanceof Collection ? $row->all() : $row;

            if ($this->header === null) {
                $header = array_map(fn ($value) => strtolower(trim((string) $value)), $row);
                $missing = array_diff(ParcelHelperService::getRequiredHeader(), $header);
                if ($missing) {
                    throw ValidationException::withMessages([
                        'file' => __('Missing header: :headers', ['headers' => implode(', ', $missing)]),
                    ]);
                }
                $this->header = $header;
                continue;
            }

            if (count($this->rows) >= self::MAX_ROWS) {
                throw ValidationException::withMessages([
                    'file' => __('Upload at most :rows parcel rows at a time. Split this file into smaller files.', ['rows' => self::MAX_ROWS]),
                ]);
            }

            $this->rows[] = $row;
        }
    }
}
