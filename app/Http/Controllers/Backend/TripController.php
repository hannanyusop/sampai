<?php

namespace App\Http\Controllers\Backend;

use App\Domains\Auth\Http\Requests\Backend\Trip\InsertParcelRequest;
use App\Domains\Auth\Http\Requests\Backend\Trip\InsertTripRequest;
use App\Domains\Auth\Models\Office;
use App\Domains\Auth\Models\Parcels;
use App\Domains\Auth\Models\ParcelTransaction;
use App\Domains\Auth\Models\Trip;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TripController extends Controller
{

    public function index(){

        $dps = Office::where('is_drop_point', 1)->get();

        return view('backend.trip.index', compact('dps'));
    }

    public function search(Request $request){

        $trips = Trip::where('code', 'LIKE', '%'.$request->code.'%')->get();

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
                                        <span class="tb-odr-status">'.getTripStatusBadge($trip->status).'</span>
                                    </td>
                                    <td class="tb-odr-amount">
                                         <span class="tb-odr-total">
                                            <span class="amount">Runner</span>
                                        </span>
                                        <span class="tb-odr-status">'.$trip->parcels->count().'Parcel(s)
                                        </span>
                                    </td>
                                    <td class="tb-odr-action">
                                        <div class="dropdown">
                                            <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-md">
                                                <ul class="link-list-plain">
                                                    <li><a href="'.route('admin.trip.view', $trip->id).'">View</a></li>
                                                    <li><a href="'.route('admin.trip.addParcel', $trip->id).'">Add Parcel</a></li>';

                                                    if($trip->status == 0){
                                                        $output .= '<li><a href="'.route('admin.trip.close', $trip->id).'">Closed</a></li>';
                                                    }elseif ($trip->status == 1){
                                                        $output .= '<li><a href="'.route('admin.trip.picked', $trip->id).'">Picked</a></li>';
                                                    }elseif ($trip->status == 2){
                                                        $output .='<li><a href="'.route('admin.trip.transferCode', $trip->id).'">Transfer Trip (runner)</a></li>';
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

        $trip = Trip::findOrFail($id);

        $parcels = Parcels::where('trip_id', $trip->id)->paginate(20);

        return view('backend.trip.view', compact('trip', 'parcels'));
    }

    public function addParcel($id){

        $trip = Trip::findOrFail($id);

        $parcels = Parcels::where('trip_id', $trip->id)->orderBy('id', 'DESC')->limit(3)->get();

        return view('backend.trip.addParcel', compact('trip', 'parcels'));
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

        $remark = "Parcel received by UTeM-mel";

        addParcelTransaction($parcel->id, $remark);
        return redirect()->back()->withFlashSuccess('Parcel inserted');
    }

    public function deleteParcel($parcel_id){
        #check either trip open or not

        $parcel = Parcels::findOrFail($parcel_id);
        $parcel->transactions()->delete();
        $parcel->delete();

        return redirect()->back()->withFlashSuccess('Parcel deleted');
    }

    public function close($id){

        $trip = Trip::where('status', 0)->findOrFail($id);

        foreach ($trip->parcels as $parcel){

            $remark = "Ready to pick by runner";

            addParcelTransaction($parcel->id, $remark);

            $parcel->status = 1;
            $parcel->save();
        }

        $trip->status = 1;
        $trip->save();

        return redirect()->back()->withFlashSuccess('Trip closed.');
    }

    public function picked($id){

        $trip = Trip::where('status', 1)->findOrFail($id);

        foreach ($trip->parcels as $parcel){

            $remark = "In transit to ".$trip->destination->name;

            addParcelTransaction($parcel->id, $remark);

            $parcel->status = 2;
            $parcel->save();
        }

        $trip->status = 2;
        $trip->save();

        return redirect()->back()->withFlashSuccess('Trip picked.');
    }

    public function receive(){

        #anyone can receive trip as long he assign on that particular office
        return view('backend.trip.receive');
    }

    public function receiveSave(Request $request){

        $trip = Trip::where('receive_code', $request->code)
            ->where('status', 2)
            ->first();

        foreach ($trip->parcels as $parcel){

            $remark = "Ready to pickup at ".$trip->destination->name;

            addParcelTransaction($parcel->id, $remark);

            $parcel->status = 3;
            $parcel->save();
        }

        $trip->status = 3;
        $trip->save();

        if(!$trip){
            return redirect()->back()->withFlashWarning('Invalid code.');
        }

        return redirect()->back()->withFlashSuccess('Code accepted.');
    }

    public function transferCode($id){

        $trip = Trip::findOrFail($id);

        return view('backend.trip.transferCode', compact('trip'));
    }
}
