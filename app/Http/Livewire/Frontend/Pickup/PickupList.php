<?php

namespace App\Http\Livewire\Frontend\Pickup;

use App\Models\Pickup;
use App\Services\Pickup\PickupHelperService;
use Livewire\Component;

class PickupList extends Component
{
    public $showAll = false, $code;

    public function render()
    {
        $pickups = Pickup::where('user_id', auth()->user()->id)
            ->when(!$this->showAll, function($query){
                return $query->where('status', '!=', PickupHelperService::STATUS_DELIVERED);
            })
            ->when($this->code, function($query){
                return $query->where('code','LIKE', '%'.$this->code.'%' );
            })
            ->orderBy('status')
            ->get();

        return view('livewire.frontend.pickup.pickup-list', compact('pickups'));
    }

}
