<?php

namespace App\Http\Controllers\Backend;

use App\Domains\Auth\Http\Requests\Backend\Office\UpdateOfficeRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\UnregisteredParcel\StoreUnregisteredParcel;
use App\Http\Requests\Backend\UnregisteredParcel\UpdateUnregisteredParcel;
use App\Models\UnregisteredParcel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UnregisteredParcelController extends Controller
{
    public function index(){
        $unregisteredParcels = UnregisteredParcel::all();
        return view('backend.unregistered_parcel.index', compact('unregisteredParcels'));
    }

    public function view($id, Request $request) {
        $this->unregistered_id = $request->route('id');

        $unregisteredParcel = UnregisteredParcel::with('parcels')->where([
            'id' => decrypt($this->unregistered_id)
        ])->find(decrypt($this->unregistered_id));
//        $unregisteredParcel = UnregisteredParcel::with('parcels')->where([
//            'id' => decrypt($id)
//        ])->find(decrypt($id))->get();
        return view('backend.unregistered_parcel.view', compact( 'unregisteredParcel', 'id'));


    }

    public function create(){

        $origins = [
            'Lazada' => 'Lazada',
            'Shopee' => 'Shopee'
        ];

        return view('backend.unregistered_parcel.create', compact( 'origins'));
    }

    public function edit($id, Request $request){
        $this->unregistered_id = $request->route('id');

        $unregisteredParcel = UnregisteredParcel::with('parcels')->where([
            'id' => decrypt($this->unregistered_id)
        ])->find(decrypt($this->unregistered_id));
//        $unregisteredParcel = UnregisteredParcel::with('parcels')->where([
//            'id' => decrypt($id)
//        ])->find(decrypt($id))->get();
        return view('backend.unregistered_parcel.edit', compact( 'unregisteredParcel', 'id'));
    }

    public function update(UpdateUnregisteredParcel $request, $id){

        $unregisteredParcel = UnregisteredParcel::findOrFail($id);

        $unregisteredParcel->tracking_no = strtoupper($request->tracking_no);
        $unregisteredParcel->receiver_name = strtoupper($request->receiver_name);
        $unregisteredParcel->phone_number = $request->phone_number;
        $unregisteredParcel->address = $request->address;
        $unregisteredParcel->order_origin = $request->order_origin;
        $unregisteredParcel->remark   = $request->remark;
        $unregisteredParcel->save();

        return redirect()->back()->withFlashSuccess('Parcel Updated');

    }

    public function store(StoreUnregisteredParcel $request){

        $unregisteredParcel = new UnregisteredParcel();
        $unregisteredParcel->tracking_no = strtoupper($request->tracking_no);
        $unregisteredParcel->receiver_name = strtoupper($request->receiver_name);
        $unregisteredParcel->phone_number = $request->phone_number;
        $unregisteredParcel->address = $request->address;
        $unregisteredParcel->order_origin = $request->order_origin;
        $unregisteredParcel->remark   = $request->remark;
        $unregisteredParcel->save();

        return redirect()->back()->withFlashSuccess('Parcel inserted');
    }
}
