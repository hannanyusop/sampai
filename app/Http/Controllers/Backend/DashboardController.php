<?php

namespace App\Http\Controllers\Backend;

use App\Domains\Auth\Models\Trip;
use App\Http\Controllers\Controller;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {

        $trips = Trip::get();

        return view('backend.dashboard', compact('trips'));
    }
}
