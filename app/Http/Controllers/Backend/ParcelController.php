<?php
namespace App\Http\Controllers\Backend;

use App\Domains\Auth\Http\Requests\Backend\Parcel\CompleteRequest;
use App\Domains\Auth\Models\Parcels;
use App\Domains\Auth\Models\User;
use App\Http\Controllers\Controller;
use App\Services\Parcel\ParcelGeneralService;
use App\Services\Parcel\ParcelHelperService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ParcelController extends Controller{

    public function index(){

        $parcels = ParcelGeneralService::query()
            ->orderBy('id', 'desc')
            ->get();

        return view('backend.parcel.index', compact('parcels'));
    }

    public function scan(){

        return view('backend.parcel.scan');
    }

    public function view(Request $request){

        if(!$request->tracking_no){
            return redirect()->back()->withFlashWarning('Invalid parameter!');
        }

        $receiver = null;

        $parcel = ParcelGeneralService::query()
            ->where('tracking_no', $request->tracking_no)
            ->first();

        if(!$parcel){
            return redirect()->back()->withFlashWarning('Parcel not found!');
        }

        if($request->uid){
            $receiver = User::find($request->uid);

            if(!$receiver){
                return redirect()->back()->withFlashWarning('Invalid user!');
            }
        }

        return view('backend.parcel.view', compact('parcel', 'receiver'));
    }

    public function deliver(CompleteRequest $request, $tracking_no){

        $parcel = Parcels::where('tracking_no', $tracking_no)->first();

        $parcel->pickup_name = $request->pickup_name;
        $parcel->pickup_info = $request->pickup_info;
        $parcel->serve_by = auth()->user()->id;
        $parcel->pickup_datetime = now();
        $parcel->status = ParcelHelperService::STATUS_DELIVERED;
        $parcel->save();

        $remark = "Parcel delivered to ".$parcel->pickup_name;

        addParcelTransaction($parcel->id, $remark);

        return redirect()->back()->withFlashSuccess('Parcel marked as received');
    }

    public function download($parcel_id)
    {

        $parcel = ParcelGeneralService::query()->find(decrypt($parcel_id));

        if (!$parcel) {
            return redirect()->back()->with('error', 'Parcel not found!');
        }

        $path = Storage::path($parcel->invoice_url);
        return response()->download($path);
    }
}
