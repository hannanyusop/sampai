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

        $trips = Trip::get();

        return view('backend.trip.index', compact('trips'));
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
        $parcel->tracking_no = strtoupper($request->tracking_no);
        $parcel->receiver_name = strtoupper($request->receiver_name);
        $parcel->receiver_info = $request->receiver_info;

        $parcel->save();

        $remark = "Parcel received by UTeM-mel on ".date('h:m A d-m-Y');

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

    public function receive(){

        #anyone can receive trip as long he assign on that particular office
        return view('backend.trip.receive');
    }

    public function receiveSave(Request $request){

        $trip = Trip::where('receive_code', $request->code)->first();

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
