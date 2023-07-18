<?php

namespace App\Http\Livewire\Backend\Trip;

use App\Domains\Auth\Models\Parcels;
use App\Domains\Auth\Models\Trip;
use App\Models\TripBatch;
use Livewire\Component;

class TripChecklistAll extends Component
{
    public TripBatch $tripBatch;
    public Parcels $last_parcel;
    public string $tracking_no = '';
    public string $message = '';
    public int $total = 0, $checked = 0, $unchecked = 0;

    public function mount(TripBatch $tripBatch)
    {
        $this->tripBatch = $tripBatch;
    }

    public function render()
    {

        $parcels =  Parcels::whereHas('pickup', function ($query)  {
            $query->whereIn('trip_id', $this->tripBatch->trips->pluck('id')->toArray());
        })
            ->orderBy('pickup_id', 'desc')
            ->get();

        $this->total = $parcels->count();
        $this->checked = $parcels->where('checked', true)->count();
        $this->unchecked = $parcels->where('checked', false)->count();

        return view('livewire.backend.trip.trip-checklist-all', compact('parcels'));
    }

    public function search(){

        $parcel =  Parcels::whereHas('pickup', function ($query)  {
            $query->whereIn('trip_id', $this->tripBatch->trips->pluck('id')->toArray());
        })
            ->where('tracking_no', $this->tracking_no)
            ->first();

        if($parcel){
            $parcel->update(['checked' => true]);
            $this->last_parcel = $parcel;

            session()->flash('success', 'Parcel found');
            return;
        }

        session()->flash('error', 'Parcel not found');

    }

    public function resetList(){
        Parcels::whereHas('pickup', function ($query)  {
            $query->whereIn('trip_id', $this->tripBatch->trips->pluck('id')->toArray());
        })->update(['checked' => false]);



        session()->flash('success', 'Checklist reset');
    }

    public function undo(){
        if($this->last_parcel){

            dd($this->last_parcel);
            $parcel = Parcels::findOrfail($this->last_parcel->id);
            $parcel->update(['checked' => false]);
            session()->flash('success', 'Undo successful');
            return;
        }

        session()->flash('error', 'Nothing to undo');
    }
}
