<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\TripBatch;
use Illuminate\Http\Request;

class BillingController extends Controller
{

    public function view(TripBatch $tripBatch){
        return view('backend.billing.view', compact('tripBatch'));
    }

    public function export(TripBatch $tripBatch){
        return (new \App\Exports\Trip\BillingListExport($tripBatch))->download('billing_'.$tripBatch->number.'_'.time().'.xlsx');
    }



}
