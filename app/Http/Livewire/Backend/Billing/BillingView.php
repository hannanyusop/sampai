<?php

namespace App\Http\Livewire\Backend\Billing;

use App\Models\Pickup;
use App\Models\TripBatch;
use Livewire\Component;
use Livewire\WithPagination;

class BillingView extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $tripBatch;

    public function mount($tripBatch)
    {
        $this->tripBatch = $tripBatch;
    }

    public function render()
    {
        $tripBatchId = $this->tripBatch->id;
        $pickups = Pickup::with(['latestNotification'])
            ->whereHas('trip', function ($query) use ($tripBatchId) {
                $query->where('trip_batch_id', $tripBatchId);
            })->paginate(20);

        return view('livewire.backend.billing.billing-view', compact('pickups'));
    }
}
