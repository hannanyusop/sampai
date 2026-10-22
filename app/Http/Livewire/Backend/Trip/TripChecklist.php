<?php

namespace App\Http\Livewire\Backend\Trip;

use App\Domains\Auth\Models\Parcels;
use App\Domains\Auth\Models\Trip;
use Livewire\Component;
use Livewire\WithPagination;

class TripChecklist extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public Trip $trip;
    public Parcels $last_parcel;
    public string $tracking_no = '';
    public string $message = '';
    public int $total = 0, $checked = 0, $unchecked = 0;

    protected function parcelQuery()
    {
        return Parcels::whereHas('pickup', fn ($query) => $query->where('trip_id', $this->trip->id));
    }

    public function render()
    {
        $query = $this->parcelQuery();
        $this->total = (clone $query)->count();
        $this->checked = (clone $query)->where('checked', true)->count();
        $this->unchecked = (clone $query)->where(function ($query) {
            $query->where('checked', false)->orWhereNull('checked');
        })->count();

        $parcels = $query->with('pickup')
            ->orderBy('parcels.id')
            ->paginate(50);

        return view('livewire.backend.trip.trip-checklist', compact('parcels'));
    }

    public function search(){
        $parcels = $this->parcelQuery()
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
        $this->parcelQuery()
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
