<?php

namespace App\Http\Controllers\API\V1;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Services\Parcel\ParcelGeneralService;
use App\Services\Parcel\ParcelHelperService;
use Illuminate\Http\Request;

class ParcelController extends Controller
{

    public function counter(){

        $pending = ParcelGeneralService::query()->whereIn('status', ParcelHelperService::PENDING_STATUS)->count();
        $processed = ParcelGeneralService::query()->whereIn('status', ParcelHelperService::PROCESSED_STATUS)->count();
        $completed = ParcelGeneralService::query()->whereIn('status', ParcelHelperService::COMPLETED_STATUS)->count();
        $ready = ParcelGeneralService::query()->whereIn('status', ParcelHelperService::READY_TO_COLLECT_STATUS)->count();

        return response(['data' => ['pending' => $pending, 'processed' => $processed, 'completed' => $completed, 'ready' => $ready]], 200);
    }

    public function index(Request $request)
    {

        $parcels = ParcelGeneralService::query()
            ->with(['dropPoint'])
            ->when($request->filter_tracking_no, function ($query) use ($request) {
                $query->where('tracking_no', 'like', '%'.$request->filter_tracking_no.'%');
            })
            ->when($request->filter_name, function ($query) use ($request) {
                $query->where('receiver_name', 'like', '%'.$request->filter_name.'%');
            })
            ->when($request->filter_phone_no, function ($query) use ($request) {
                $query->where('phone_number', 'like', '%'.$request->filter_phone_no.'%');
            })
            ->whereNotIn('status', ParcelHelperService::COMPLETED_STATUS)
            ->orderBy('updated_at', 'desc')
            ->paginate(20);

        return response(['data' => $parcels], 200);

    }

    public function show($id)
    {
        $parcel = ParcelGeneralService::query()
            ->with(['transactions'])
            ->find($id);

        if (!$parcel) {
            return response(['error' => 'Parcel not found'], 404);
        }

        return response(['data' => $parcel], 200);
    }

    public function store(Request $request)
    {

        // Example in a controller method
        $validator = Validator::make($request->all(), [
            "tracking_no"   => "required|unique:parcels,tracking_no|max:50",
            "receiver_name" => "required|max:100",
            "phone_number"  => "required|max:20",
            "description"   => "required|max:1000",
            "quantity"      => "required|numeric|min:1",
            "price"         => "required|numeric",
            "invoice_url"   => "required|file|max:20048",
            "order_origin"  => "required|max:50",
            "office_id"     => "required|exists:offices,id",
        ],[
            'tracking_no.unique' => 'The tracking no has been submitted in PARCEL LIST.',
            'invoice_url.max' => 'The invoice may not be greater than 20 MB.',
            'invoice_url.file' => 'The invoice must be a file.',
            'invoice_url.required' => 'Please upload invoice.',

            'office_id.required' => 'Please select drop point.'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->first()], 422);
        }


        $result = ParcelGeneralService::store($request);

        return response(['message' => $result['message'], 'data' => $result['data']], $result['code']);
    }


    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            "tracking_no"   => "required|unique:parcels,tracking_no,$id|max:50",
            "receiver_name" => "required|max:100",
            "phone_number"  => "required|max:20",
            "description"   => "required|max:1000",
            "quantity"      => "required|numeric|min:1",
            "price"         => "required|numeric",
            "invoice_url"   => "file|max:20048",
            "order_origin"  => "required|max:50",
            "office_id"     => "required|exists:offices,id",
        ],[
            'tracking_no.required' => 'The tracking number field is required',
            'tracking_no.unique' => 'The tracking already exist.',
            'invoice_url.max' => 'The invoice may not be greater than 20 MB.',
            'invoice_url.file' => 'The invoice must be a file.',
            'invoice_url.required' => 'Please upload invoice.',

            'office_id.required' => 'Please select drop point.'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $parcel = ParcelGeneralService::query()->find($id);

        if (!$parcel) {
            return response(['message' => 'Parcel not found'], 404);
        }

        $parcel = ParcelGeneralService::update($request, $parcel);

        return response(['message' => 'Parcel updated successfully', 'data' => $parcel], 200);
    }

    public function destroy($id)
    {
        $parcel = ParcelGeneralService::query()->find($id);

        if (!$parcel) {
            return response(['error' => 'Parcel not found'], 404);
        }

        $parcel->delete();

        return response(['message' => 'Parcel deleted successfully'], 200);
    }
}
