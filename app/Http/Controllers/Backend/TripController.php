<?php

namespace App\Http\Controllers\Backend;

use App\Domains\Auth\Http\Requests\Backend\Trip\InsertParcelRequest;
use App\Domains\Auth\Http\Requests\Backend\Trip\InsertTripRequest;
use App\Domains\Auth\Models\Office;
use App\Domains\Auth\Models\Parcels;
use App\Domains\Auth\Models\ParcelTransaction;
use App\Domains\Auth\Models\Subscribe;
use App\Domains\Auth\Models\Trip;
use App\Http\Controllers\Controller;
use App\Models\Pickup;
use App\Models\TripBatch;
use App\Services\General\GeneralHelperService;
use App\Services\Parcel\ParcelGeneralService;
use App\Services\Parcel\ParcelHelperService;
use App\Services\Pickup\PickupHelperService;
use App\Services\Trip\TripHelperService;
use App\Services\TripBatch\TripBatchGeneralService;
use Illuminate\Http\Request;

class TripController extends Controller
{

    public function index(){

        $dps = Office::where('is_drop_point', 1)->get();

        return view('backend.trip.index', compact('dps'));
    }

    public function search(Request $request){

        $query = Trip::where('code', 'LIKE', '%'.$request->code.'%');

        $status = ($request->status)? $request->status : [];
        $destination_id = ($request->office_id)? $request->office_id : "";


        $query->whereIn('status', $status)
            ->whereIn('destination_id', $destination_id);


        $trips = $query->get();
        $output = "";

        foreach ($trips as $trip){

            $output .= '<tr class="tb-odr-item">
                                    <td class="tb-odr-info">
                                        <span class="tb-odr-id"><a href="#">'.$trip->code.'</a></span>
                                        <span class="tb-odr-date">'.$trip->date.'</span>
                                    </td>
                                    <td class="tb-odr-amount">
                                        <span class="tb-odr-total">
                                            <span class="amount">'.$trip->destination->code.'</span>
                                        </span>
                                        <span class="tb-odr-status">'.$trip->status_badge.'</span>
                                    </td>
                                    <td class="tb-odr-amount">
                                         <span class="tb-odr-total">
                                            <span class="amount"></span>
                                        </span>
                                        <span class="tb-odr-status">'.$trip->parcels->count().'Parcel(s)
                                        </span>
                                    </td>
                                    <td class="tb-odr-action">
                                        <div class="dropdown">
                                            <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-md">
                                                <ul class="link-list-plain">
                                                    <li><a href="'.route('admin.trip.view', $trip->id).'">View</a></li>';

                                                    if(auth()->user()->can('staff.distributor')) {

                                                        if($trip->status == 0){
                                                            $output .= '<li><a href="' . route('admin.trip.addParcel', $trip->id) . '">Add Parcel</a></li>';
                                                            $output .= '<li><a href="'.route('admin.trip.close', $trip->id).'" onclick="return confirm(\'Are you sure want to close this trip?\')">Close Trip</a></li>';
                                                        }
                                                    }
                                                    if (auth()->user()->can('staff.runner')){
                                                        if ($trip->status == 1){
                                                            $output .= '<li><a href="'.route('admin.trip.picked', $trip->id).'">Pick Trip</a></li>';
                                                        }elseif ($trip->status == 2 && $trip->runner_id == auth()->user()->id){
                                                            $output .='<li><a href="'.route('admin.trip.transferCode', $trip->id).'">Transfer Trip</a></li>';
                                                        }
                                                    }

                                    $output .= '</ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>';
        }

        return $output;
    }

    public function create(){

        $opened_trip = Trip::where('status', 0)->pluck('destination_id')->toArray();
        $drops = Office::where('is_drop_point', 1)->get();

        return view('backend.trip.create', compact('drops', 'opened_trip'));
    }

    public function insert(InsertTripRequest $request){

        $trip = new Trip();

        $trip->user_id = auth()->user()->id;
        $trip->code = generateTripCode($request->destination_id, $request->date);
        $trip->date = date('Y-m-d');
        $trip->receive_code = generateTripReceiveCode();
        $trip->destination_id = $request->destination_id;
        $trip->remark = $request->remark;

        $trip->save();
        return  redirect()->back()->withFlashSuccess('New trip created.');
    }

    public function edit($id){

        $trip = Trip::findOrFail($id);

        $drops = Office::where('is_drop_point', 1)->get();

        return view('backend.trip.edit', compact('drops', 'trip'));
    }

    public function update(InsertTripRequest $request, $id){

        $trip = Trip::findOrFail($id);

        $trip->user_id = auth()->user()->id;
        $trip->destination_id = $request->ad;
        $trip->remark = $request->remark;

        $trip->save();
        return  redirect()->back()->withFlashSuccess('Trip updated.');
    }

    public function view($id){

        $trip = Trip::with('parcels')->findOrFail($id);

        $parcels = $trip->parcels;

        return view('backend.trip.view', compact('trip', 'parcels'));
    }

    public function masterList($id){

            $trip = Trip::findOrFail($id);

            return view('backend.trip.master-list', compact('trip'));
    }

    public function addParcel(Request $request, $id){

        $trip = Trip::findOrFail($id);

        $pending_parcels = Parcels::where([
            'office_id' => $trip->destination_id,
            'pickup_id'  => null
        ])
            ->when($request->tracking_no, function ($q) use ($request){
                $q->where('tracking_no', 'LIKE',  '%'.$request->tracking_no.'%');
            })
            ->get();

        $sName = Parcels::select([ \DB::raw('DISTINCT receiver_name')])->get()->toArray();
//        $sInfo = Parcels::select([ \DB::raw('DISTINCT receiver_info')])->get()->toArray();

        if($trip->status != 0){
            return redirect()->back()->withFlashWarning('Trip has been closed.');
        }

        $parcels = $trip->parcels()->orderBy('id', 'DESC')->limit(3)->get();

        return view('backend.trip.addParcel', compact('trip', 'parcels', 'sName', 'pending_parcels'));
    }

    public function assignParcel(Trip $trip, Parcels $parcel){

        $service = ParcelGeneralService::assignToPickup($parcel, $trip, $trip->office);

        return redirect()->back()->with($service[GeneralHelperService::KEY_STATUS], GeneralHelperService::KEY_MESSAGE);
    }

    public function insertParcel(InsertParcelRequest $request, $id){
        #check either trip open or not
        $trip = Trip::findOrFail($id);

        $parcel = new Parcels();
        $parcel->trip_id = $trip->id;
        $parcel->status = 0;
        $parcel->tracking_no = strtoupper($request->tracking_no);
        $parcel->receiver_name = strtoupper($request->receiver_name);
        $parcel->receiver_info = $request->receiver_info;
        $parcel->save();

        $remark = "Parcel received by our staff.";

        addParcelTransaction($parcel->id, $remark);
        return redirect()->back()->withFlashSuccess('Parcel inserted');
    }

//    public function deleteParcel($parcel_id){
//        #check either trip open or not
//
//
//        $parcel = Parcels::findOrFail($parcel_id);
//
//
//        if($parcel->status == ParcelHelperService::STATUS_RECEIVED){
//
//            $parcel->update([
//                'pickup_id' => null,
//                'status'    => ParcelHelperService::STATUS_REGISTERED
//            ]);
//            return redirect()->back()->withFlashSuccess('Parcel unassigned');
//        }else{
//            return redirect()->back()->withFlashError('Parcel cannot be deleted! Reason : Status in '.getParcelStatus($parcel->status));
//        }
//
//
//    }

    public function close($trip_batch_id){

        $batch = TripBatch::whereHas('trips', function ($q) use ($trip_batch_id){
            $q->where('status', TripHelperService::STATUS_PENDING);
        })->findOrFail($trip_batch_id);

//        if($batch->parcels->count() == 0){
//            return redirect()->back()->with('flash_danger', 'Trip cannot be closed. Reason : There are no parcel inserted.');
//        }

        foreach ($batch->parcels as $parcel){
            addParcelTransaction($parcel->id, ParcelHelperService::statuses(ParcelHelperService::STATUS_OUTBOUND_TO_DROP_POINT));
            $parcel->status = ParcelHelperService::STATUS_OUTBOUND_TO_DROP_POINT;
            $parcel->save();
        }

        $batch->trips()->update([
            'status' => TripHelperService::STATUS_CLOSED
        ]);

        return redirect()->back()->withFlashSuccess('Trip closed.');
    }

    public function picked($id){

        $result = TripBatchGeneralService::pick($id);
        return redirect()->back()->withFlashSuccess($result['message']);
    }

    public function receive(){

        #anyone can receive trip as long he assign on that particular office
        if(auth()->user()->office_id != 0){

            $office = Office::where('is_drop_point', 1)->find(auth()->user()->office_id);

            if(!$office){

                return redirect()->back()->withFlashWarning('Only staff under drop point office can receive this parcel!');
            }

            return view('backend.trip.receive');
        }else{

            return redirect()->back()->withFlashWarning('Permission denied! (You\'re not belong to any drop point office.)');
        }
    }

    public function scan(){

        #anyone can receive trip as long he assign on that particular office
        if(auth()->user()->office_id != 0){

            return view('backend.trip.scan');
        }else{

            return redirect()->back()->withFlashWarning('Permission denied! (You\'re not belong to any drop point office.)');
        }
    }

    public function receiveSave(Request $request){

        $trip = Trip::where('receive_code', $request->code)
            ->where('status', TripHelperService::STATUS_IN_TRANSIT)
            ->first();

        if(!$trip){
            return redirect()->back()->withFlashWarning('Invalid code.');
        }

        if($trip->destination_id != auth()->user()->office_id){

            return redirect()->back()->withFlashWarning('This trip is not belong to yor office.');
        }

        $this->updateReceive($trip->id);

        return redirect()->back()->withFlashSuccess('Code accepted.');
    }

    private function updateReceive($trip_id){

        $trip = Trip::where('id', $trip_id)
            ->where('status', ParcelHelperService::STATUS_OUTBOUND_TO_DROP_POINT)
            ->first();

       Pickup::where('trip_id', $trip_id)->update([
            'status' => PickupHelperService::STATUS_READY_TO_DELIVER
        ]);

        foreach ($trip->parcels as $parcel){

            $remark = "Ready to collect at ".$trip->destination->name;

            addParcelTransaction($parcel->id, $remark);

            $parcel->status = ParcelHelperService::STATUS_INBOUND_TO_DROP_POINT;
            $parcel->save();
        }

        $trip->status = TripHelperService::STATUS_ARRIVED;
        $trip->save();
    }

    public function transferCode($id){

        $trip = Trip::findOrFail($id);

        return view('backend.trip.transferCode', compact('trip'));
    }

    public function checklist(Trip $trip){
        return view('backend.trip.checklist', compact('trip'));
    }
}
