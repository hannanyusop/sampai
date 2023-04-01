<?php

namespace App\Http\Livewire\Backend\TripBatch;

use App\Domains\Auth\Models\Office;
use App\Domains\Auth\Models\Trip;
use App\Models\TripBatch;
use App\Services\TripBatch\TripBatchHelperService;
use Livewire\Component;

class TripBatchCreate extends Component
{
    public $remark, $date;
    public function render()
    {
        return view('livewire.backend.trip-batch.trip-batch-create');
    }

    public function store(){

        $pendingBatch = TripBatch::where('status', TripBatchHelperService::STATUS_PENDING)->first();

        if($pendingBatch){
            $this->addError('remark', 'Please close the pending batch first.');
        }

        $this->validate([
            'remark' => 'max:255',
        ]);

        $date = date('Y-m-d');

        $tripBatch = new TripBatch();
        $tripBatch->created_by = auth()->user()->id;
        $tripBatch->date = $date;
        $tripBatch->save();

        $dp = Office::where('is_drop_point', 1)->get();

        foreach ($dp as $office){

            $trip = new Trip();
            $trip->trip_batch_id = $tripBatch->id;
            $trip->user_id = auth()->user()->id;
            $trip->code = generateTripCode($office->id, $tripBatch->date);
            $trip->receive_code = generateTripReceiveCode();
            $trip->destination_id = $office->id;
            $trip->save();
        }

        $this->reset();
        return redirect()->route('admin.tripBatch.show', $tripBatch->id)->with('success', 'Trip Batch created successfully.');
    }
}
