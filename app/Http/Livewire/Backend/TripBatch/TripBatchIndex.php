<?php

namespace App\Http\Livewire\Backend\TripBatch;

use App\Models\TripBatch;
use App\Services\TripBatch\TripBatchGeneralService;
use Livewire\Component;

class TripBatchIndex extends Component
{
    public $statuses = [], $tripBatchId = null;
    public function mount(){

    }

    public function render()
    {
        $batches = TripBatchGeneralService::query()
            ->when(count($this->statuses) > 0, fn($query) => $query->whereHas('trips', fn($q) => $q->whereIn('status', $this->statuses)))
            ->when($this->tripBatchId, fn($query) => $query->where('id', $this->id))
            ->orderBy('id', 'desc')
            ->get();

        return view('livewire.backend.trip-batch.trip-batch-index', compact('batches'));
    }
}
