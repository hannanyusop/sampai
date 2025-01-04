<?php

namespace App\Http\Livewire\Backend\TripBatch;

use App\Domains\Auth\Models\Office;
use App\Domains\Auth\Models\User;
use App\Exports\parcel\ExportBulk;
use App\Exports\parcel\ExportBulkTemplate;
use App\Models\TripBatch;
use App\Services\General\GeneralHelperService;
use App\Services\Parcel\ParcelGeneralService;
use App\Services\Parcel\ParcelHelperService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class TripBatchBulkImport extends Component
{
    use WithFileUploads;
    public TripBatch $tripBatch;

    public $file;
    public $header = [];
    public $customers = [];
    public $parcels = [];

    public $offices = [];

    public function mount()
    {
        $this->customers = User::where('type', User::TYPE_USER)->get();
        $this->offices = Office::where('is_drop_point', 1)->get();
    }

    public function render()
    {
        return view('livewire.backend.trip-batch.trip-batch-bulk-import');
    }

    public function downloadTemplate()
    {
       return Excel::download(new ExportBulkTemplate(), 'bulk_import_template.xlsx');
    }

    public function viewData()
    {
        $this->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);


        $array = Excel::toArray([], $this->file->getRealPath());

        $header = array_map('strtolower', $array[0][0]);
        $header = array_map('trim', $header);

        $requiredHeader = ParcelHelperService::getRequiredHeader();



        foreach ($requiredHeader as $value) {

            if (!in_array($value, $header)) {
                dd('error');
//                NotificationGeneralService::flashNotification(ServiceResultStatusEnum::Error, 'Missing header ' . $value);
                return;
            }
        }

        $content = array_slice($array[0], 1);

        $header[] = 'id';
        $header[] = 'actual_name';

        $this->header = $header;

        foreach ($content as $key => $value) {

            $phone    = $value[2];
            $customer = $this->customers->where('phone_number', $phone)->first();
            $cid = $customer->id ?? null;

            $this->parcels[$key] = [
                'tracking' => $value[0],
                'name'     => $value[1],
                'phone'    => $value[2],
                'destination' => $value[3],
                'id'          => $cid,
                'actual_name' => $customer->name ?? null,
                'customer_id' => $cid,
            ];

        }

    }

    public function storeAction()
    {
        $this->validate([
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
    }

}
