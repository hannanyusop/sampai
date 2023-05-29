<?php

namespace App\Http\Livewire\Backend\Parcel;

use App\Domains\Auth\Models\Parcels;
use Livewire\Component;

class ParcelPickup extends Component
{
    public $tracking_no;
    public $parcel;
    public function render()
    {
        return view('livewire.backend.parcel.parcel-pickup');
    }

    public function search(){
        $this->parcel = Parcels::where('tracking_no', '239579286587876')->first();
    }
}
