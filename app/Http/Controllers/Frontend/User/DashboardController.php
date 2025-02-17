<?php

namespace App\Http\Controllers\Frontend\User;

use App\Domains\Auth\Models\Subscribe;
use App\Http\Controllers\Controller;

class DashboardController extends Controller{

    public function index()
    {


        return view('frontend.user.dashboard');
    }
}
