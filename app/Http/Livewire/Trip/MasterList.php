<?php

namespace App\Http\Livewire\Trip;

use App\Domains\Auth\Models\Parcels;
use App\Domains\Auth\Models\Trip;
use Livewire\Component;

class MasterList extends Component
{
    public $trip, $tax;
    public $tracking_no, $edited_id = null;

    public function mount($trip_id)
    {
        $this->trip = Trip::findOrFail($trip_id);
    }

    public function render()
    {
        $parcels = Parcels::when($this->tracking_no, function ($query) {
            $query->where('tracking_no', 'like', '%' . $this->tracking_no . '%');
        })->where('trip_id', $this->trip->id)
            ->get();
        return view('livewire.trip.master-list', compact('parcels'));
    }

    public function changeEditedId($id)
    {
        $parcel = $this->trip->parcels()->where('id', $id)->first();

        if(!$parcel){
            return session()->flash('error', 'Parcel not found.');
        }

        $this->edited_id = $id;
        $this->tax = $parcel->tax;
    }

    public function updateTax()
    {
        //validate
        $this->validate([
            'tax' => 'required|numeric|min:0.01'
        ]);


        $parcel = $this->trip->parcels()->where('id', $this->edited_id)->first();

        if(!$parcel){
            return session()->flash('error', 'Parcel not found.');
        }

        $parcel->tax = $this->tax;
        $parcel->save();

        $this->edited_id = null;
        $this->tax = null;

        return session()->flash('success', 'Tax updated successfully.');
    }
}
