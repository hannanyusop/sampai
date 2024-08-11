<?php

namespace App\Http\Livewire\Office;

use App\Domains\Auth\Models\Office;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class ReceivingRemark extends Component
{
    public Office $office;

    public $offices = [];

    public $pickup_remark = null;

    public function mount(Office $office){

       $this->office = $office;

       $this->pickup_remark = $office->pickup_remark;
    }

    public function render()
    {
        return view('livewire.office.receiving-remark');
    }

    public function save(){

        $office = $this->office;
        $office->pickup_remark = $this->pickup_remark;
        $office->save();

        Session::flash('success', 'Okay');
    }
}
