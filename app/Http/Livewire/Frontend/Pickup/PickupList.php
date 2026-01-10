<?php

namespace App\Http\Livewire\Frontend\Pickup;

use App\Models\Pickup;
use App\Services\Pickup\PickupHelperService;
use Livewire\Component;
use Livewire\WithPagination;

class PickupList extends Component
{
    use WithPagination;

    public $code = '';
    public $status = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 15;

    protected $queryString = [
        'code' => ['except' => ''],
        'status' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function updatingCode()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function clearFilters()
    {
        $this->code = '';
        $this->status = '';
        $this->resetPage();
    }

    public function getStatusesProperty()
    {
        return [
            PickupHelperService::STATUS_PENDING => __('Pending'),
            PickupHelperService::STATUS_READY_TO_DELIVER => __('Ready to Deliver'),
            PickupHelperService::STATUS_PICKUP_POINT_PROCESS => __('Processing'),
            PickupHelperService::STATUS_DELIVERED => __('Delivered'),
        ];
    }

    public function render()
    {
        $pickups = Pickup::where('user_id', auth()->user()->id)
            ->when($this->status !== '', function($query) {
                return $query->where('status', $this->status);
            })
            ->when($this->code, function($query) {
                return $query->where('code', 'LIKE', '%' . $this->code . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.frontend.pickup.pickup-list', [
            'pickups' => $pickups,
            'statuses' => $this->statuses,
        ]);
    }
}
