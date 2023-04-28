<?php

namespace App\Http\Livewire\Backend\Trip;

use App\Domains\Auth\Models\Parcels;
use App\Domains\Auth\Models\Trip;
use Livewire\Component;

class TripChecklist extends Component
{
    public Trip $trip;
    public Parcels $last_parcel;
    public string $tracking_no = '';
    public string $message = '';
    public int $total = 0, $checked = 0, $unchecked = 0;

    public function render()
    {
        $parcels = Parcels::whereHas('pickup',  fn($query) => $query->where('trip_id', $this->trip->id))
            ->get();

        $this->total = $parcels->count();
        $this->checked = $parcels->where('checked', true)->count();
        $this->unchecked = $parcels->where('checked', false)->count();

        return view('livewire.backend.trip.trip-checklist', compact('parcels'));
    }

    public function search(){
        $parcels = Parcels::whereHas('pickup',  fn($query) => $query->where('trip_id', $this->trip->id))
            ->where('tracking_no', $this->tracking_no)
            ->first();

        if($parcels){
            $parcels->update(['checked' => true]);
            $this->last_parcel = $parcels;

            session()->flash('success', 'Parcel found');
            return;
        }

        session()->flash('error', 'Parcel not found');

    }

    public function resetList(){
        Parcels::whereHas('pickup',  fn($query) => $query->where('trip_id', $this->trip->id))
            ->update(['checked' => false]);


        session()->flash('success', 'Checklist reset');
    }

    public function undo(){
        if($this->last_parcel){

            $parcel = Parcels::findOrfail($this->last_parcel->id);
            $parcel->update(['checked' => false]);
            session()->flash('success', 'Undo successful');
            return;
        }

        session()->flash('error', 'Nothing to undo');
    }
}
