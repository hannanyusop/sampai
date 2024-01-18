<?php

namespace App\Http\Livewire\Backend\TripBatch;

use App\Domains\Auth\Models\Parcels;
use App\Exports\Trip\BiaccExport;
use App\Imports\Parcel\OfflineParcelImport;
use App\Models\TripBatch;
use App\Services\General\GeneralHelperService;
use App\Services\Parcel\ParcelGeneralService;
use App\Services\TripBatch\TripBatchHelperService;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class TripBatchShow extends Component
{
    public $edit_parcel_id = null, $guni_edit, $service_charge_edit;
    public $filter_tracking_no = null, $filter_name = null, $filter_phone_no = null;
    public $tripBatch, $tracking_no = "", $last_parcel;
    public bool $edit_rate = false, $showUploadForm = false;
    public $excel;
    public $guni = '';
    public $tax_rate = 0.00, $pos_rate = 0.00,  $service_charge = 0.00, $cod_fee = 0.00;

    use WithFileUploads;


    public function mount(TripBatch $tripBatch)
    {

        $this->tripBatch = $tripBatch;
        $this->tax_rate = $tripBatch->tax_rate;
        $this->pos_rate = $tripBatch->pos_rate;
    }

    public function render()
    {

//        if(Str::length($this->tracking_no) > 5 && $this->tracking_no != $this?->last_parcel?->tracking_no){
//            $this->search();
//        }

        $tripBatch = $this->tripBatch;

        $parcels =  Parcels::whereHas('pickup', function ($query) use ($tripBatch) {
            $query->whereIn('trip_id', $tripBatch->trips->pluck('id')->toArray());
        })
            ->when($this->filter_tracking_no, function ($query) {
                $query->where('tracking_no', 'like', '%'.$this->filter_tracking_no.'%');
            })
            ->when($this->filter_name, function ($query) {
                $query->where('receiver_name', 'like', '%'.$this->filter_name.'%');
            })
            ->when($this->filter_phone_no, function ($query) {
                $query->where('phone_number', 'like', '%'.$this->filter_phone_no.'%');
            })
            ->orderBy('updated_at', 'desc')
            ->paginate(20);

        return view('livewire.backend.trip-batch.trip-batch-show', compact('tripBatch', 'parcels'));
    }

    public function search(){

        $service = ParcelGeneralService::insertableParcel($this->tracking_no, $this->tripBatch);

        if ($service[GeneralHelperService::KEY_STATUS] == GeneralHelperService::STATUS_ERROR) {
            return session()->flash('insert_'.GeneralHelperService::STATUS_ERROR, $service[GeneralHelperService::KEY_MESSAGE]);
        }

        if ($service[GeneralHelperService::KEY_STATUS] == GeneralHelperService::STATUS_SUCCESS) $this->last_parcel = $service[GeneralHelperService::KEY_DATA];

        $this->cod_fee         = $service[GeneralHelperService::KEY_DATA]->cod_fee;
        $this->service_charge  = $service[GeneralHelperService::KEY_DATA]->service_charge;
        $this->guni            = $service[GeneralHelperService::KEY_DATA]->guni;

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
            'cod_fee'        => $this->cod_fee,
        ]);

        if ($service[GeneralHelperService::KEY_STATUS] == GeneralHelperService::STATUS_SUCCESS) $this->last_parcel = Parcels::where('tracking_no', $tracking_no)->first();

        session()->flash('insert_'.$service[GeneralHelperService::KEY_STATUS],$service[GeneralHelperService::KEY_MESSAGE]);

//        $this->last_parcel = null;
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

        $this->tracking_no = "";
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

    public function resetFilter(){
        $this->filter_tracking_no = null;
        $this->filter_name = null;
        $this->filter_phone_no = null;
    }


    #region edit rate

    public function editParcel(Parcels $parcel){
        $this->edit_parcel_id = $parcel->id;

        $this->guni_edit = $parcel->guni;
        $this->service_charge_edit = $parcel->service_charge;
    }

    public function updateParcel(Parcels $parcel){
        $this->validate([
            'guni_edit' => 'required|max:50',
            'service_charge_edit' => 'required|numeric|min:0',
        ]);

        $parcel->update([
            'guni' => $this->guni_edit,
            'service_charge' => $this->service_charge_edit,
        ]);

        $this->edit_parcel_id = null;

        session()->flash('insert_'.GeneralHelperService::STATUS_SUCCESS, __('Rate updated successfully.'));
    }

    public function exportBiacc()
    {
        return (new BiaccExport($this->tripBatch))->download('trip_'.$this->tripBatch->number.'_BIACC_'.time().'.xlsx');

    }

    #endregion
}
