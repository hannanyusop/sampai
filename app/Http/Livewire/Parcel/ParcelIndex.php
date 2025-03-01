<?php

namespace App\Http\Livewire\Parcel;

use App\Services\Parcel\ParcelGeneralService;
use Livewire\Component;
use Livewire\WithPagination;

class ParcelIndex extends Component
{
    protected $paginationTheme = 'bootstrap';
    public $paginate = 10;
    public $search = '';

    use WithPagination;

    public function render()
    {
        $parcels = ParcelGeneralService::query()
            ->with('dropPoint')
            ->orderBy('status')
            ->orderBy('id', 'desc')
            ->where( 'tracking_no', 'like', '%' . $this->search . '%')
            ->paginate($this->paginate);

        return view('livewire.parcel.parcel-index', compact('parcels'));
    }
}
