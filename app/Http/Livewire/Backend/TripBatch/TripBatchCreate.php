<?php

namespace App\Http\Livewire\Backend\TripBatch;

use App\Domains\Auth\Models\Office;
use App\Domains\Auth\Models\Trip;
use App\Models\TripBatch;
use App\Services\Trip\TripHelperService;
use App\Services\TripBatch\TripBatchHelperService;
use Livewire\Component;

class TripBatchCreate extends Component
{
    public $remark, $date;

    public $receiver_offices = [];

    public $office_id = null;

    public function mount()
    {

        $this->receiver_offices = Office::where('is_receiver', 1)->get();
    }
    public function render()
    {
        return view('livewire.backend.trip-batch.trip-batch-create');
    }

    public function store(){

        $this->validate([
           'office_id' => 'required|exists:offices,id,is_receiver,1',
        ],[
            'office_id.required' => 'Please select office.',
            'office_id.exists' => 'Please select valid office.',
        ]);


        $date = date('Y-m-d');

        $tripBatch = new TripBatch();
        $tripBatch->office_id  = $this->office_id;
        $tripBatch->is_closed  = 0;
        $tripBatch->created_by = auth()->user()->id;
        $tripBatch->date       = $date;
        $tripBatch->tax_rate   = getOption('tax_rate', 0.307);
        $tripBatch->pos_rate   = getOption('pos_rate', 2.800);
        $tripBatch->save();

        $dp = Office::where('is_drop_point', 1)->get();

        foreach ($dp as $office){

            $trip = new Trip();
            $trip->status         = TripHelperService::STATUS_PENDING;
            $trip->trip_batch_id  = $tripBatch->id;
            $trip->user_id        = auth()->user()->id;
            $trip->code           = generateTripCode($office->id, $tripBatch->date);
            $trip->receive_code   = generateTripReceiveCode();
            $trip->destination_id = $office->id;
            $trip->save();
        }

        $this->reset();
        return redirect()->route('admin.tripBatch.show', $tripBatch->id)->with('success', 'Trip Batch created successfully.');
    }
}
