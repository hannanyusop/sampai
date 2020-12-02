<?php

namespace App\Http\Controllers\Frontend\User;

use App\Domains\Auth\Models\Subscribe;
use App\Http\Controllers\Controller;

class DashboardController extends Controller{

    public function index()
    {
        $subscribes = Subscribe::where('user_id', auth()->user()->id)
            ->get();

        return view('frontend.user.dashboard', compact('subscribes'));
    }
}
