<?php

namespace App\Http\Livewire\Backend\Parcel;

use App\Domains\Auth\Models\Office;
use App\Services\Parcel\ParcelGeneralService;
use Livewire\Component;
use Livewire\WithPagination;

class ParcelList extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $pickup_offices = [];
    public $office_id = 0, $status = 0, $tracking_no, $owner;

    public function mount(){

        $this->pickup_offices = Office::where('is_drop_point', 1)->get();
    }
    public function render()
    {

        $parcels = ParcelGeneralService::query()
            ->with('user', 'pickup')
            ->where('tracking_no', 'like', '%'.$this->tracking_no.'%')
            ->when($this->office_id != 0, function($query){
                $query->where('office_id', $this->office_id);
            })
            ->when($this->status != 0, function($query){
                $query->where('status', $this->status);
            })
            ->whereHas('user', function($query){
                $query->where('name', 'like', '%'.$this->owner.'%')
                    ->orWhere('phone_number', 'like', '%'.$this->owner.'%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);


        return view('livewire.backend.parcel.parcel-list', compact('parcels'));
    }

    public function updated($propertyName)
    {
        $this->dispatchBrowserEvent('property-updated', ['property' => $propertyName]);
    }

    public function resetPage()
    {
        $this->resetPage();
    }
}
