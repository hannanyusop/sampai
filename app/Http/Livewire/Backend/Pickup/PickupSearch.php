<?php

namespace App\Http\Livewire\Backend\Pickup;

use App\Models\Pickup;
use App\Services\Parcel\ParcelGeneralService;
use App\Services\Parcel\ParcelHelperService;
use App\Services\Pickup\PickupHelperService;
use Livewire\Component;

class PickupSearch extends Component
{
    public $code;
    public $pickup = null;
    public $pickup_name;

    public function render()
    {
        return view('livewire.backend.pickup.pickup-search');
    }

    public function search(){
        $this->pickup = null;

        $pickup = $this->pickup = Pickup::where('code', $this->code)->first();

        if(!$this->pickup){
            session()->flash('error', __('No pickup found with this tracking number'));
            return;
        }

        $this->pickup_name = $pickup->user->name;

    }

    public function deliver(){

        if (!auth()->user()->can('staff.inhouse')){
            session()->flash('error', __('You are not authorized to deliver pickup'));
            return;
        }

        if ($this->pickup->status != PickupHelperService::STATUS_READY_TO_DELIVER){
            session()->flash('error', __('Pickup already not ready to deliver'));
            return;
        }

        if ($this->pickup->office_id != auth()->user()->office_id){
            session()->flash('error', __('This Pickup not belongs to your office'));
            return;
        }

        $this->validate([
            'pickup_name' => 'required'
        ]);

        \DB::beginTransaction();

        $this->pickup->update([
            'status' => PickupHelperService::STATUS_DELIVERED,
            'pickup_name' => $this->pickup_name,
            'pickup_datetime' => now(),
            'serve_by' => auth()->user()->id
        ]);

        foreach ($this->pickup->parcels as $parcel){
            ParcelGeneralService::deliver($parcel , $this->pickup_name);
        }

        \DB::commit();

        session()->flash('success', __('Pickup delivered successfully'));
    }
}
