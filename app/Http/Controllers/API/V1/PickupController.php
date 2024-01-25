<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Pickup;
use App\Services\Pickup\PickupHelperService;
use Illuminate\Http\Request;

class PickupController
{

    public function index(Request $request)
    {

        $pickups = Pickup::where('user_id', auth()->user()->id)
            ->where('status', PickupHelperService::STATUS_READY_TO_DELIVER)
//            ->when(!$this->showAll, function($query){
//                return $query
//            })
            ->when($request->code, function($query) use ($request){
                return $query->where('code','LIKE', '%'.$request->code.'%' );
            })
            ->orderBy('status')
            ->get();

        return response(['data' => $pickups], 200);

    }

    public function show(Pickup $pickup)
    {
        if ($pickup->user_id != auth()->user()->id) {
            return response(['error' => 'Pickup not found'], 404);
        }

        return response(['data' => $pickup], 200);
    }

}
