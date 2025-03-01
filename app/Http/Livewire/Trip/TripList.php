<?php

namespace App\Http\Livewire\Trip;

use App\Domains\Auth\Models\Trip;
use App\Services\TripBatch\TripBatchHelperService;
use Livewire\Component;
use Livewire\WithPagination;

class TripList extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $paginate = 10;
    public function render()
    {
        $trips = Trip::with('destination')
            ->withCount('parcels')
            ->whereIn('status', [TripBatchHelperService::STATUS_IN_TRANSIT, TripBatchHelperService::STATUS_ARRIVED])
            ->where('destination_id', auth()->user()->office_id)
            ->paginate($this->paginate);
        return view('livewire.trip.trip-list', compact('trips'));
    }
}
