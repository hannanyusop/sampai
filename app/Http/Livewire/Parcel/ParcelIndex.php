<?php

namespace App\Http\Livewire\Parcel;

use App\Services\Parcel\ParcelGeneralService;
use App\Services\Parcel\ParcelHelperService;
use Livewire\Component;
use Livewire\WithPagination;

class ParcelIndex extends Component
{
    protected $paginationTheme = 'bootstrap';
    public $paginate = 10;
    public $search = '';
    public $status = '';

    use WithPagination;

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->status = '';
        $this->resetPage();
    }

    public function render()
    {
        $query = ParcelGeneralService::query()
            ->with('dropPoint')
            ->orderBy('status')
            ->orderBy('id', 'desc');

        // Search by tracking number
        if (!empty($this->search)) {
            $query->where('tracking_no', 'like', '%' . $this->search . '%');
        }

        // Filter by status
        if ($this->status !== '' && $this->status !== null) {
            $query->where('status', $this->status);
        }

        $parcels = $query->paginate($this->paginate);

        $statuses = ParcelHelperService::statuses();

        return view('livewire.parcel.parcel-index', compact('parcels', 'statuses'));
    }
}
