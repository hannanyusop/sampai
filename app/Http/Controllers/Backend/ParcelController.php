<?php
namespace App\Http\Controllers\Backend;

use App\Domains\Auth\Http\Requests\Backend\Parcel\CompleteRequest;
use App\Domains\Auth\Models\Parcels;
use App\Domains\Auth\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ParcelController extends Controller{

    public function index(){

        if(auth()->user()->can('staff.distributor')){

            $parcels = Parcels::leftJoin('trips', 'trips.id', 'parcels.trip_id')
                ->get();

        }else{

            $parcels = Parcels::leftJoin('trips', 'trips.id', 'parcels.trip_id')
                ->where('trips.destination_id', auth()->user()->office_id)
                ->get();
        }

        return view('backend.parcel.index', compact('parcels'));

    }

    public function scan(){

        return view('backend.parcel.scan');
    }

    public function view(Request $request){

        if($request->tracking_no){

            $tracking_no = $request->tracking_no;

            $receiver = null;

            $parcel = Parcels::where('tracking_no', $request->tracking_no)->first();

            if(auth()->user()->can('staff.distributor')){


            }else{

                if($parcel->trip->destination_id != auth()->user()->office_id){

                    return redirect()->back()->withFlashWarning('Parcel not found!');
                }

            }

            if(!$parcel){
                return redirect()->back()->withFlashWarning('Parcel not found!');
            }

            if($request->uid){
                $receiver = User::find(decrypt($request->uid));

                if(!$receiver){
                    return redirect()->back()->withFlashWarning('Invalid user!');
                }
            }

            return view('backend.parcel.view', compact('parcel', 'receiver'));

        }else{
            return redirect()->back()->withFlashWarning('Invalid parameter!');
        }



    }

    public function deliver(CompleteRequest $request, $tracking_no){

        $parcel = Parcels::where('tracking_no', $tracking_no)->first();

        $parcel->pickup_name = $request->pickup_name;
        $parcel->pickup_info = $request->pickup_info;
        $parcel->serve_by = auth()->user()->id;
        $parcel->pickup_datetime = now();
        $parcel->status = 4;
        $parcel->save();

        $remark = "Parcel delivered to ".$parcel->pickup_name;

        addParcelTransaction($parcel->id, $remark);

        return redirect()->back()->withFlashSuccess('Parcel marked as received');
    }
}
