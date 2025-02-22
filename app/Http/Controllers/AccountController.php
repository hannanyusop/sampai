<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function updatePassword()
    {
        return view('account.update-password');
    }
}
