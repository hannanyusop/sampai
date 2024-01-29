<?php
namespace App\Http\Controllers\Frontend\User;

use App\Domains\Auth\Models\Office;
use App\Domains\Auth\Models\Parcels;
use App\Domains\Auth\Models\TrackHistories;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Parcel\StoreParcelRequest;
use App\Models\UnregisteredParcel;
use App\Services\Parcel\ParcelGeneralService;
use App\Services\Parcel\ParcelHelperService;
use App\Http\Requests\Frontend\Parcel\UpdateParcelRequest;
//use App\Http\Services\Parcel\ParcelHelperService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ParcelController extends Controller{

    public function index(){

        $parcels = ParcelGeneralService::query()
            ->orderBy('status')
            ->orderBy('id', 'desc')
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
            'user_id' => auth()->user()->id,
        ])->find(decrypt($id));


        if(!$parcel){
            return redirect()->back()->with('warning', 'Parcel not found!');
        }

        if ($parcel->status != ParcelHelperService::STATUS_REGISTERED) {
            return redirect()->back()->with('warning', 'Please contact admin to edit this parcel.');
        }

        $receiver = null;

        return view('frontend.user.parcel.edit', compact('parcel', 'drop_points', 'receiver'));
    }

    public function update(UpdateParcelRequest $request, $id){

        $parcel = Parcels::where([
            'user_id' => auth()->user()->id,
            'status' => ParcelHelperService::STATUS_REGISTERED
        ])->findOrFail($id);


        $result = ParcelGeneralService::update($request, $parcel);

        return redirect()->back()->with($result['status'], $result['message']);


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
        $file                  = Storage::disk('public')->put('invoice', $request->file('invoice_url'));
        $parcel->invoice_url   = $file;
        $parcel->save();

        $unregistered = UnregisteredParcel::where([
            'tracking_no' => $request->tracking_no,
            'parcel_id' => null
        ])->first();

        if($unregistered){
            $unregistered->parcel_id = $parcel->id;
            $unregistered->save();
        }

        addParcelTransaction($parcel->id, ParcelHelperService::statuses(ParcelHelperService::STATUS_REGISTERED));
        return redirect()->back()->withFlashSuccess('Parcel inserted');
    }

    public function download($parcel_id)
    {

        $parcel = ParcelGeneralService::query()->find(decrypt($parcel_id));

        if (!$parcel) {
            return redirect()->back()->with('error', 'Parcel not found!');
        }

        if (!Storage::disk('public')->exists($parcel->invoice_url)) {
            $path = Storage::path($parcel->invoice_url);
            return response()->download($path);
        }

        return response()->download(Storage::disk('public')->path($parcel->invoice_url));


    }
}
