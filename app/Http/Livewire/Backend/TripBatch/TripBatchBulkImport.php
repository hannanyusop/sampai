<?php

namespace App\Http\Livewire\Backend\TripBatch;

use App\Domains\Auth\Models\Office;
use App\Domains\Auth\Models\User;
use App\Exports\parcel\ExportBulk;
use App\Exports\parcel\ExportBulkTemplate;
use App\Models\TripBatch;
use App\Imports\Parcel\BulkPreviewImport;
use App\Imports\Parcel\BulkPreviewSheet;
use App\Services\General\GeneralHelperService;
use App\Services\Parcel\ParcelGeneralService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class TripBatchBulkImport extends Component
{
    use WithFileUploads;
    public TripBatch $tripBatch;

    public $file;
    public $header = [];
    public $customerSearch = '';
    public $parcels = [];

    public $offices = [];

    public function mount()
    {
        $this->offices = Office::where('is_drop_point', 1)->get();
    }

    public function render()
    {
        validator(['customerSearch' => $this->customerSearch], ['customerSearch' => 'nullable|string|max:100'])->validate();
        $query = User::where('type', User::TYPE_USER)->select('id', 'name', 'phone_number');
        $matches = (clone $query)->when($this->customerSearch !== '', function ($query) {
            $query->where(function ($query) {
                $query->where('name', 'like', '%'.$this->customerSearch.'%')
                    ->orWhere('phone_number', 'like', '%'.$this->customerSearch.'%');
            });
        })->orderBy('id')->limit(25)->toBase()->get();
        $selectedIds = collect($this->parcels)->pluck('customer_id')->filter()->unique();
        $selected = (clone $query)->whereIn('id', $selectedIds)->toBase()->get();
        $customers = $matches->merge($selected)->unique('id');
        $customerMatchIds = $matches->pluck('id')->all();

        return view('livewire.backend.trip-batch.trip-batch-bulk-import', compact('customers', 'customerMatchIds'));
    }

    public function downloadTemplate()
    {
       return Excel::download(new ExportBulkTemplate(), 'bulk_import_template.xlsx');
    }

    public function updatedFile()
    {
        $this->parcels = [];
        $this->header = [];
        $this->resetValidation();
    }

    public function viewData()
    {
        $this->validate([
            'file' => 'required|file|mimes:xlsx,xls|max:10240',
        ]);


        // Validate the whole bounded preview before replacing the current rows.
        $import = new BulkPreviewImport;
        Excel::import($import, $this->file);
        if ($import->sheet->header === null) {
            $this->addError('file', __('The spreadsheet is empty.'));
            return;
        }

        $customersByPhone = [];
        $parcels = [];
        foreach ($import->sheet->rows as $key => $value) {
            $phone = (string) ($value[2] ?? '');
            if (! array_key_exists($phone, $customersByPhone)) {
                $customersByPhone[$phone] = User::where('type', User::TYPE_USER)
                    ->where('phone_number', $phone)
                    ->without(['roles', 'permissions'])
                    ->orderBy('id')->first(['id', 'name']);
            }
            $customer = $customersByPhone[$phone];
            $cid = $customer->id ?? null;
            $parcels[$key] = [
                'tracking' => $value[0] ?? '',
                'name' => $value[1] ?? '',
                'phone' => $value[2] ?? '',
                'destination' => $value[3] ?? '',
                'id' => $cid,
                'actual_name' => $customer->name ?? null,
                'customer_id' => $cid,
            ];
        }
        $this->header = array_merge($import->sheet->header, ['id', 'actual_name']);
        $this->parcels = $parcels;
    }

    public function storeAction()
    {
        $this->validate([
            'parcels' => 'required|array|max:'.BulkPreviewSheet::MAX_ROWS,
            'parcels.*.customer_id' => 'required|numeric|exists:users,id,type,' . User::TYPE_USER,
            'parcels.*.destination' => 'required|exists:offices,code,is_drop_point,1',
            'parcels.*.tracking'    => 'unique:parcels,tracking_no',
        ], [
            'parcels.*.customer_id.required' => 'Please select customer',
            'parcels.*.customer_id.exists'   => 'Selected customer not found / invalid',
            'parcels.*.destination.required' => 'Please select destination',
            'parcels.*.destination.exists'   => 'Selected destination not found / invalid',
            'parcels.*.tracking.unique'      => 'Tracking number already registered. Remove duplicate tracking number',
        ]);

        //convert parcels.*.customer_id to integer
        $this->parcels = array_map(function($parcel){
            $parcel['customer_id'] = (int) $parcel['customer_id'];
            return $parcel;
        }, $this->parcels);

        $service = ParcelGeneralService::exportBulk($this->tripBatch, $this->parcels);

        $data   = $service[GeneralHelperService::KEY_DATA];
        $export = new ExportBulk($data);
        return Excel::download($export, "bulk_import_".time().".xlsx");
    }

    public function clearAction()
    {
        $this->parcels = [];
        $this->file = null;
        $this->header = [];
        $this->customerSearch = '';
        $this->resetValidation();
    }

}
