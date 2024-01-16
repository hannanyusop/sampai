<?php

namespace App\Http\Controllers\Backend;

use App\Domains\Auth\Models\Office;
use App\Domains\Auth\Models\Trip;
use App\Http\Controllers\Controller;
use App\Models\TripBatch;
use App\Services\Parcel\ParcelHelperService;
use App\Services\TripBatch\TripBatchGeneralService;
use App\Services\TripBatch\TripBatchHelperService;

class TripBatchController extends Controller
{
    public function index(){
        return view('backend.trip_batch.index');
    }

    public function create(){

        if (!auth()->user()->can('admin.trip.open')){
            return redirect()->back()->withFlashWarning('You don\'t have permission to open trip.');
        }

        return view('backend.trip_batch.create');
    }

    public function show(TripBatch $tripBatch){

        $tripBatch = TripBatchGeneralService::query()->find($tripBatch->id);

        if (!$tripBatch) return redirect()->back()->withFlashWarning('Trip batch not found!');

        return view('backend.trip_batch.show', compact('tripBatch'));
    }

    public function edit(){
        return view('backend.trip_batch.edit');
    }

    public function close($id){

        $batch = TripBatch::where('status', TripBatchHelperService::STATUS_PENDING)->findOrFail($id);

        foreach ($batch->parcels as $parcel){

            $remark = ParcelHelperService::statuses(ParcelHelperService::STATUS_OUTBOUND_TO_DROP_POINT);
            addParcelTransaction($parcel->id, $remark);

            $parcel->status = ParcelHelperService::STATUS_OUTBOUND_TO_DROP_POINT;
            $parcel->save();
        }

        $batch->status = TripBatchHelperService::STATUS_CLOSED;
        $batch->save();

        return redirect()->route('admin.tripBatch.index')->withFlashSuccess('Trip closed.');
    }

    public function picked($id){

        if(!auth()->user()->can('staff.runner'))
            return redirect()->back()->withFlashWarning('Permission denied!');

        $batch = TripBatch::where('status', TripBatchHelperService::STATUS_CLOSED)->findOrFail($id);

        foreach ($batch->parcels as $parcel){

            $remark = "In transit to ".$batch->dropPoint->name.". RIDER:".auth()->user()->name;
            addParcelTransaction($parcel->id, $remark);

            $parcel->status = ParcelHelperService::STATUS_OUTBOUND_TO_DROP_POINT;
            $parcel->save();
        }

        $batch->runner_id = auth()->user()->id;
        $batch->status = TripBatchHelperService::STATUS_IN_TRANSIT;
        $batch->save();

        return redirect()->back()->withFlashSuccess('Trip picked.');
    }

    public function receive(){

        #anyone can receive trip as long he assign on that particular office
        if(auth()->user()->office_id == 0)
            return redirect()->back()->withFlashWarning('Permission denied! (You\'re not belong to any drop point office.)');

        $office = Office::where('is_drop_point', 1)->find(auth()->user()->office_id);

        if(!$office) return redirect()->back()->withFlashWarning('Only staff under drop point office can receive this parcel!');

        return view('backend.trip_batch.receive');
    }

}
