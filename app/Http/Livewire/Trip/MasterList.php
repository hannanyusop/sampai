<?php

namespace App\Http\Livewire\Trip;

use App\Domains\Auth\Models\Parcels;
use App\Exports\Trip\MasterListExport;
use App\Models\TripBatch;
use Cknow\Money\Money;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;


class MasterList extends Component
{
    public $trip_batch, $trip_ids = [];
    public $trip, $tax;
    public $tracking_no, $edited_id = null;

    public function mount($trip_id)
    {
        $this->trip_batch = TripBatch::with('trips')->findOrFail($trip_id);
        $this->trip_ids = $this->trip_batch->trips()->pluck('id');
    }

    public function render()
    {
        $parcels = Parcels::whereHas('pickup', function($query){
            $query->whereIn('trip_id', $this->trip_ids);
        })->when($this->tracking_no, function ($query) {
            $query->where('tracking_no', 'like', '%' . $this->tracking_no . '%');
        })->get();

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
    }

    public function updateTax()
    {
        $this->validate([
            'tax' => 'required|numeric|min:0.01'
        ]);

        $parcel = Parcels::whereHas('pickup', function($query){
            $query->whereIn('trip_id', $this->trip_ids);
        })->find($this->edited_id);

        if(!$parcel){
            return session()->flash('error', 'Parcel not found.');
        }

        $parcel->tax = $this->tax;
        $parcel->save();

        $this->edited_id = null;
        $this->tax = null;

        return session()->flash('success', 'Tax updated successfully.');
    }

    public function export(){
        return Excel::download(new MasterListExport($this->trip_batch), time()."_".$this->trip_batch->number.'.xlsx');
    }
}
