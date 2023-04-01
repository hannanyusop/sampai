<?php

namespace App\Http\Livewire\Backend\TripBatch;

use App\Models\TripBatch;
use Livewire\Component;

class TripBatchIndex extends Component
{
    public $statuses = [], $tripBatchId = null;
    public function mount(){

    }

    public function render()
    {
        $batches = TripBatch
            ::when(count($this->statuses) > 0, fn($query) => $query->whereIn('status', $this->statuses))
            ->when($this->tripBatchId, fn($query) => $query->where('id', $this->id))
            ->get();

        return view('livewire.backend.trip-batch.trip-batch-index', compact('batches'));
    }
}
