<?php

namespace App\Domains\Auth\Http\Controllers\Frontend\Auth;

use App\Domains\Auth\Models\PasswordReset;
use App\Domains\Auth\Rules\UnusedPassword;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Domains\Auth\Models\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use LangleyFoxall\LaravelNISTPasswordRules\PasswordRules;

/**
 * Class ResetPasswordController.
 */
class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * @return string
     */
    public function redirectPath()
    {
        return route(homeRoute());
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'token' => ['required'],
            'email' => ['required', 'max:255', 'email'],
            'password' => array_merge(
                [
                    'max:100',
                    new UnusedPassword(request('email')),
                ],
                PasswordRules::changePassword(request('email'))
            ),
        ];
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm(Request $request, $token = null)
    {

        $reset = PasswordReset::where('token', $token)->first();

        if(!$reset){

            return redirect()->back()->withErrors('Invalid token!');
        }

        return view('frontend.auth.passwords.reset', compact('reset'));
    }

    public function reset(Request $request){


        $v = Validator::make($request->all(),[
            'token' => ['required'],
            'password' => 'confirmed|required|min:5'
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }

        $reset = PasswordReset::where('token', $request->token)->firstOrFail();

        $user = User::where('email', $reset->email)->first();

        $user->password = $request->password;
        $user->save();

        \DB::table('password_resets')->where('token', $request->token)->delete();

        auth()->login($user);
        return redirect()->route(homeRoute())->withFlashSuccess('Reset password successfully');
    }
}
