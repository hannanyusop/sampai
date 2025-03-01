<?php

namespace App\Http\Livewire\Backend\TripBatch;

use App\Models\TripBatch;
use App\Services\TripBatch\TripBatchGeneralService;
use Livewire\Component;
use Livewire\WithPagination;

class TripBatchIndex extends Component
{
    public $statuses = [], $tripBatchId = null;

    protected $paginationTheme = 'bootstrap';

    use WithPagination;
    public $paginate = 10;
    public function mount(){

    }

    public function render()
    {
        $batches = TripBatchGeneralService::query()
            ->with('office')
            ->when(count($this->statuses) > 0, fn($query) => $query->whereHas('trips', fn($q) => $q->whereIn('status', $this->statuses)))
            ->when($this->tripBatchId, fn($query) => $query->where('id', $this->id))
            ->orderBy('id', 'desc')
            ->paginate($this->paginate);

        return view('livewire.backend.trip-batch.trip-batch-index', compact('batches'));
    }
}
