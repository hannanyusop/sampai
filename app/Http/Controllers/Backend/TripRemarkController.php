<?php

namespace App\Http\Controllers\Backend;

use App\Domains\Auth\Http\Requests\Backend\TripRemark\InsertTripRemark;
use App\Domains\Auth\Models\Trip;
use App\Domains\Auth\Models\TripRemark;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TripRemarkController extends Controller{

    public function create(InsertTripRemark $request, $id){


        Trip::findOrFail($id);

        $remark = new TripRemark();
        $remark->trip_id = $id;
        $remark->user_id = auth()->user()->id;
        $remark->text = $request->text;
        $remark->save();

        return redirect()->back()->withFlashSuccess('Remark inserted!');
    }

    public function delete($id){


        $trip = TripRemark::where('user_id', auth()->user()->id )->findOrFail($id);

        $trip->delete();

        return redirect()->back()->withFlashSuccess('Remark deleted!');
    }
}
