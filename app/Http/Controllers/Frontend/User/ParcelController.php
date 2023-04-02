<?php
namespace App\Http\Controllers\Frontend\User;

use App\Domains\Auth\Models\Office;
use App\Domains\Auth\Models\Parcels;
use App\Domains\Auth\Models\TrackHistories;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Parcel\StoreParcelRequest;
use App\Services\Parcel\ParcelHelperService;
use App\Http\Requests\Frontend\Parcel\UpdateParcelRequest;
//use App\Http\Services\Parcel\ParcelHelperService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ParcelController extends Controller{

    public function index(){

        $parcels = Parcels::where('user_id', auth()->user()->id)
            ->get();

        return view('frontend.user.parcel.index', compact('parcels'));
    }

    public function view($id){

        $parcel = Parcels::with('dropPoint')->where([
            'user_id' => auth()->user()->id
        ])->find(decrypt($id));


        if(!$parcel){
            return redirect()->back()->with('warning', 'Parcel not found!');
        }

        $receiver = null;

        return view('frontend.user.parcel.view', compact('parcel', 'receiver'));
    }

    public function edit($id){
        $drop_points = Office::where('is_drop_point', 1)->get();

        $parcel = Parcels::with('dropPoint')->where([
            'user_id' => auth()->user()->id
        ])->find(decrypt($id));


        if(!$parcel){
            return redirect()->back()->with('warning', 'Parcel not found!');
        }

        $receiver = null;

        return view('frontend.user.parcel.edit', compact('parcel', 'drop_points', 'receiver'));
    }

    public function update(UpdateParcelRequest $request, $id){

        $parcel = Parcels::findOrFail($id);

        $parcel->tracking_no = strtoupper($request->tracking_no);
        $parcel->description = strtoupper($request->description);
        $parcel->quantity = $request->quantity;
        $parcel->price = $request->price;
        $parcel->tax = $request->tax;
        $parcel->save();

        return redirect()->back()->withFlashSuccess('Parcel Updated');

    }


    public function search(Request $request){
        $parcel = null;

        if($request->tracking_no){

            if(paymentEnabled()){

                $bal = getMaxTrack()-auth()->user()->todayTracks->count();

                if($bal > 0){

                    $track = new TrackHistories();
                    $track->user_id = auth()->user()->id;
                    $track->tracking_no = $request->tracking_no;
                    $track->save();
                }else{

                    return redirect()->route('frontend.user.parcel.search')->withErrors('You already reach limit for today.');
                }

            }
            $parcel = Parcels::where('tracking_no', $request->tracking_no)->first();
        }

        return view('frontend.user.parcel.search', compact('parcel'));
    }

    public function create(){

        $origins = [
            'Lazada' => 'Lazada',
            'Shopee' => 'Shopee'
        ];
        $drop_points = Office::where('is_drop_point', 1)->get();

        return view('frontend.user.parcel.create', compact('drop_points', 'origins'));
    }

    public function store(StoreParcelRequest $request){


        $parcel = new Parcels();
        $parcel->user_id       = auth()->user()->id;
        $parcel->tracking_no   = strtoupper($request->tracking_no);
        $parcel->status        = ParcelHelperService::STATUS_REGISTERED;
        $parcel->receiver_name = strtoupper($request->receiver_name);
        $parcel->phone_number  = $request->phone_number;
        $parcel->description   = $request->description;
        $parcel->price         = $request->price;
        $parcel->quantity      = $request->quantity;
        $parcel->order_origin  = $request->order_origin;
        $parcel->office_id     = $request->office_id;
        $file                  = Storage::put('invoice', $request->file('invoice_url'));
        $parcel->invoice_url   = $file;
        $parcel->save();

        addParcelTransaction($parcel->id, ParcelHelperService::statuses(ParcelHelperService::STATUS_REGISTERED));
        return redirect()->back()->withFlashSuccess('Parcel inserted');
    }
}
