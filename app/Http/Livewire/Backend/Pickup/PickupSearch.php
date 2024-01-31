<?php

namespace App\Http\Livewire\Backend\Pickup;

use App\Models\Pickup;
use App\Services\Parcel\ParcelGeneralService;
use App\Services\Parcel\ParcelHelperService;
use App\Services\Pickup\PickupGeneralService;
use App\Services\Pickup\PickupHelperService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class PickupSearch extends Component
{
    use WithFileUploads;

    public $code;
    public $pickup = null;
    public $pickup_name;

    public $payment_method, $total_payment, $prof_of_delivery;

    public function render()
    {
        return view('livewire.backend.pickup.pickup-search');
    }

    public function search(){
        $this->pickup = null;

        $pickup = $this->pickup = Pickup::where('code', $this->code)->first();

        if(!$this->pickup){
            session()->flash('error', __('No pickup found with this code'));
            return;
        }

        $this->pickup_name = $pickup->user->name;
        $this->total_payment = $pickup->total;

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
            'pickup_name'      => 'required',
            'payment_method'   => 'required|in:'.implode(',', array_keys(PickupHelperService::paymentMethodLabel())),
            'total_payment'    => 'required|numeric|min:0.00',
            'prof_of_delivery' => 'nullable|file|max:20024',
        ]);

        $file = null;
        if ($this->prof_of_delivery){

            if ($this->pickup->prof_of_delivery){
                Storage::delete($this->pickup->prof_of_delivery);
            }

            $file = Storage::disk('public')->put('pickup', $this->prof_of_delivery);

        }

        $request = new Request();
        $request->pickup_name = $this->pickup_name;
        $request->payment_method = $this->payment_method;
        $request->total_payment = $this->total_payment;
        $request->prof_of_delivery = $file;
        $request->total_price = $this->pickup->total;

        $result = PickupGeneralService::deliver($request, $this->pickup);

        session()->flash($result['status'], $result['message']);
    }
}
