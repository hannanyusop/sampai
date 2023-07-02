<?php

namespace App\Http\Livewire\Trip;

use App\Domains\Auth\Models\Parcels;
use App\Exports\Trip\MasterListExport;
use App\Models\TripBatch;
use App\Services\Parcel\ParcelHelperService;
use Cknow\Money\Money;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;


class MasterList extends Component
{
    public TripBatch $trip_batch;
    public $trip, $tax, $trip_ids = [], $service_charge = 0.00, $percent = 0.00, $price = 0.00, $currency_exchange = 0.00, $permit = 0.00;
    public $cod_fee_ori;
    public $tracking_no, $edited_id = null;

    public bool $edit_rate = false;
    public $tax_rate = 0.00, $pos_rate = 0.00;

    public function mount($trip_id)
    {
        $this->trip_batch = TripBatch::with('trips')->findOrFail($trip_id);

        $this->currency_exchange = $this->trip_batch->tax_rate;

        $this->trip_ids = $this->trip_batch->trips()->pluck('id');

        $this->tax_rate = $this->trip_batch->tax_rate;
        $this->pos_rate = $this->trip_batch->pos_rate;
    }

    public function render()
    {
        $parcels = Parcels::whereHas('pickup', function($query){
            $query->whereIn('trip_id', $this->trip_ids);
        })->when($this->tracking_no, function ($query) {
            $query->where('tracking_no', 'like', '%' . $this->tracking_no . '%');
        })
            ->orderBy('user_id', 'asc')
            ->get();

        return view('livewire.trip.master-list', compact('parcels'));
    }

    public function changeEditedId($id)
    {

        $parcel = Parcels::whereHas('pickup', function($query){
            $query->whereIn('trip_id', $this->trip_ids);
        })->find($id);

        if(!$parcel){
            return session()->flash('error', 'Parcel not found.');
        }

        $this->edited_id = $id;
        $this->tax = $parcel->tax;
        $this->price = $parcel->price;
        $this->percent = $parcel->percent;
        $this->service_charge = $parcel->service_charge;
        $this->permit = $parcel->permit;
        $this->cod_fee_ori = $parcel->cod_fee_ori;


    }

    public function updateTax()
    {
        $this->validate([
            'price'          => 'required|numeric|min:0.01',
            'percent'        => 'required|numeric|min:0|max:100',
            'service_charge' => 'required|numeric|min:0.01',
            'permit'         => 'required|numeric|min:0.01',
            'cod_fee_ori'    => 'required|numeric|min:0.00',
        ]);

        $parcel = Parcels::whereHas('pickup', function($query){
            $query->whereIn('trip_id', $this->trip_ids);
        })->find($this->edited_id);

        if(!$parcel){
             session()->flash('error', 'Parcel not found.');
             return;
        }

        $parcel->tax = ParcelHelperService::CalculateTax($this->price,$this->currency_exchange, $this->percent);
        $parcel->price = $this->price;
        $parcel->percent = $this->percent;
        $parcel->service_charge = $this->service_charge;
        $parcel->permit = $this->permit;
        $parcel->cod_fee_ori = $this->cod_fee_ori;
        $parcel->cod_fee = ParcelHelperService::ConvertToBND($this->cod_fee_ori, $this->pos_rate);
        $parcel->save();

        $this->edited_id = null;
        $this->tax = null;

        session()->flash('success', 'Tax updated successfully.');
        return;
    }

    public function updateTaxValue(){
        $this->tax = ParcelHelperService::CalculateTax($this->price,$this->currency_exchange, $this->percent);
    }

    public function export(){
        return Excel::download(new MasterListExport($this->trip_batch), time()."_".$this->trip_batch->number.'.xlsx');
    }

    public function editRate(){
        $this->edit_rate = true;
    }

    public function saveRate(){

        $this->trip_batch->update([
            'tax_rate' => $this->tax_rate,
            'pos_rate' => $this->pos_rate
        ]);

        session()->flash("success", "Data updated!");
        $this->edit_rate = false;
    }
}
