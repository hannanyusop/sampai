<?php

namespace App\Http\Livewire\Backend\TripBatch;

use App\Domains\Auth\Models\Parcels;
use App\Imports\Parcel\OfflineParcelImport;
use App\Models\TripBatch;
use App\Services\General\GeneralHelperService;
use App\Services\Parcel\ParcelGeneralService;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class TripBatchShow extends Component
{
    public $tripBatch, $tracking_no, $last_parcel;
    public bool $edit_rate = false, $showUploadForm = false;
    public $excel;
    public string $guni;
    public $tax_rate = 0.00, $pos_rate = 0.00,  $service_charge = 0.00;

    use WithFileUploads;


    public function mount($tripBatch)
    {
        $this->tripBatch = $tripBatch;
        $this->tax_rate = $tripBatch->tax_rate;
        $this->pos_rate = $tripBatch->pos_rate;
    }

    public function render()
    {
        $tripBatch = $this->tripBatch;

        $parcels =  Parcels::whereHas('pickup', function ($query) use ($tripBatch) {
            $query->whereIn('trip_id', $tripBatch->trips->pluck('id')->toArray());
        })
            ->orderBy('pickup_id', 'desc')
            ->paginate(20);

        return view('livewire.backend.trip-batch.trip-batch-show', compact('tripBatch', 'parcels'));
    }

    public function search(){

        $service = ParcelGeneralService::insertableParcel($this->tracking_no, $this->tripBatch);

        if ($service[GeneralHelperService::KEY_STATUS] == GeneralHelperService::STATUS_ERROR) {
            return session()->flash('insert_'.GeneralHelperService::STATUS_ERROR, $service[GeneralHelperService::KEY_MESSAGE]);
        }

        if ($service[GeneralHelperService::KEY_STATUS] == GeneralHelperService::STATUS_SUCCESS) $this->last_parcel = $service[GeneralHelperService::KEY_DATA];

    }

    public function save(){

        $tracking_no = Str::upper($this->tracking_no);

        $parcel = Parcels::where('tracking_no', $tracking_no)->first();

        if (!$parcel) {
            return session()->flash('insert_'.GeneralHelperService::STATUS_ERROR, __('No parcel found for :tracking_no', ['tracking_no' => $tracking_no]));
        }

        if (in_array(auth()->user()->office_id, [3,4])) {
            return session()->flash('insert_'.GeneralHelperService::STATUS_ERROR, __('You are not authorized to add parcel.'));
        }

        $service = ParcelGeneralService::assignToTripBatch($tracking_no, $this->tripBatch);

        $parcel->update([
            'service_charge' => $this->service_charge,
            'guni'           => $this->guni,
        ]);

        if ($service[GeneralHelperService::KEY_STATUS] == GeneralHelperService::STATUS_SUCCESS) $this->last_parcel = Parcels::where('tracking_no', $tracking_no)->first();

        session()->flash('insert_'.$service[GeneralHelperService::KEY_STATUS],$service[GeneralHelperService::KEY_MESSAGE]);
    }

    public function deleteParcel($id){

        $service = ParcelGeneralService::undoTripBatch($this->tripBatch, $id);

        if ($service[GeneralHelperService::KEY_STATUS] == GeneralHelperService::STATUS_SUCCESS) $this->last_parcel = null;

        session()->flash('insert_'.$service[GeneralHelperService::KEY_STATUS],$service[GeneralHelperService::KEY_MESSAGE]);
    }

    public function undo(){

        if (!$this->last_parcel) return;

        $service = ParcelGeneralService::undoTripBatch($this->tripBatch, $this->last_parcel->id);


        if ($service[GeneralHelperService::KEY_STATUS] == GeneralHelperService::STATUS_SUCCESS) $this->last_parcel = null;

        session()->flash('insert_'.$service[GeneralHelperService::KEY_STATUS],$service[GeneralHelperService::KEY_MESSAGE]);
    }

    public function cancel(){

        $this->tracking_no = null;
        $this->last_parcel = null;
    }

    //upload excel

    public function upload()
    {
        $this->validate([
            'excel' => 'required|file|mimes:xlsx',
        ]);

        Excel::import(new OfflineParcelImport($this->tripBatch), $this->excel);
    }

    public function showUploadForm(){
        $this->showUploadForm = true;
    }

    public function hideUploadForm(){
        $this->showUploadForm = false;
    }
}
