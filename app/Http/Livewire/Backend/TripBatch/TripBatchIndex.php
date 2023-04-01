<?php

namespace App\Http\Livewire\Backend\TripBatch;

use App\Models\TripBatch;
use Livewire\Component;

class TripBatchIndex extends Component
{
    public $status = null;
    public function mount(){

    }

    public function render()
    {
        $batches = TripBatch::when($this->status, function($query){
            return $query->where('status', $this->status);
        })->get();

        return view('livewire.backend.trip-batch.trip-batch-index', compact('batches'));
    }
}
