<?php

namespace App\Http\Livewire\Backend\TripBatch;

use App\Domains\Auth\Models\Parcels;
use App\Models\TripBatch;
use App\Services\General\GeneralHelperService;
use App\Services\Parcel\ParcelGeneralService;
use Illuminate\Support\Str;
use Livewire\Component;

class TripBatchShow extends Component
{
    public TripBatch $tripBatch, $tracking_no, $last_parcel;
    public bool $edit_rate = false;
    public float $tax_rate = 0.00, $pos_rate = 0.00;

    public function mount(TripBatch $tripBatch)
    {
        $this->tripBatch = $tripBatch;
        $this->tax_rate = $tripBatch->tax_rate;
        $this->pos_rate = $tripBatch->pos_rate;
    }

    public function render()
    {
        $tripBatch = $this->tripBatch;

        return view('livewire.backend.trip-batch.trip-batch-show', compact('tripBatch'));
    }

    public function insert(){

        $tracking_no = Str::upper($this->tracking_no);

        $service = ParcelGeneralService::assignToTripBatch($tracking_no, $this->tripBatch);

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

}
