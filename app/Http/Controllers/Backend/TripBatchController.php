<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\TripBatch;

class TripBatchController extends Controller
{
    public function index(){
        return view('backend.trip_batch.index');
    }

    public function create(){
        return view('backend.trip_batch.create');
    }

    public function show(TripBatch $tripBatch){
        return view('backend.trip_batch.show', compact('tripBatch'));
    }

    public function edit(){
        return view('backend.trip_batch.edit');
    }
}
