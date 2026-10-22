<?php

namespace App\Http\Livewire\Backend\Trip;

use App\Domains\Auth\Models\Parcels;
use App\Domains\Auth\Models\Trip;
use App\Models\TripBatch;
use Livewire\Component;
use Livewire\WithPagination;

class TripChecklistAll extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public TripBatch $tripBatch;
    public Parcels $last_parcel;
    public string $tracking_no = '';
    public string $message = '';
    public int $total = 0, $checked = 0, $unchecked = 0;

    public function mount(TripBatch $tripBatch)
    {
        $this->tripBatch = $tripBatch;
    }

    protected function parcelQuery()
    {
        return Parcels::whereHas('pickup', function ($query) {
            $query->whereIn('trip_id', $this->tripBatch->trips()->select('trips.id'));
        });
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
            ->orderBy('pickup_id', 'desc')
            ->orderBy('parcels.id')
            ->paginate(50);

        return view('livewire.backend.trip.trip-checklist-all', compact('parcels'));
    }

    public function search(){

        $parcel =  $this->parcelQuery()
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
        $this->parcelQuery()->update(['checked' => false]);



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
