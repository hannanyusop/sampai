<?php

namespace App\Domains\Auth\Http\Controllers\Frontend\Auth;

use App\Domains\Auth\Models\User;
use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;
use App\Mail\UserVerify;
use App\Rules\Captcha;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule;

/**
 * Class ForgotPasswordController.
 */
class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    public function sendResetLinkEmail(Request $request){

        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'exists:users,email'],
        ]);


        $data = \App\Domains\Auth\Models\PasswordReset::where(['email' => $request->email])->first();


        if(!$data){
            $token = bin2hex(random_bytes(16));
            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => now()
            ]);

            $data = \App\Domains\Auth\Models\PasswordReset::orderBy('created_at', 'DESC')->first();
        }




        Mail::to($request->email)->send(new ResetPassword($data));

        return redirect()->back()->withFlashSuccess('Link for reset password has been sent to '.$request->email);
    }

    protected function validateEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
    }

    public function showLinkRequestForm()
    {
        return view('frontend.auth.passwords.email');
    }
}
