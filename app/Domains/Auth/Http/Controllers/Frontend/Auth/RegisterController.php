<?php

namespace App\Domains\Auth\Http\Controllers\Frontend\Auth;

use App\Domains\Auth\Events\User\UserCreated;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Services\UserService;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Rules\Captcha;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use LangleyFoxall\LaravelNISTPasswordRules\PasswordRules;

/**
 * Class RegisterController.
 */
class RegisterController extends Controller
{

    public function redirectPath()
    {
        return route(homeRoute());
    }

    public function showRegistrationForm()
    {
        abort_unless(config('boilerplate.access.user.registration'), 404);

        return view('frontend.auth.register');
    }

    protected function validator(array $data)
    {
//        array_merge(['max:100'], PasswordRules::register($data['email'] ?? null))
        return Validator::make($data, [

        ], [
            'terms.required' => __('You must accept the Terms & Conditions.'),
            'g-recaptcha-response.required_if' => __('validation.required', ['attribute' => 'captcha']),
        ]);
    }

    public function register(Request $request){

//        array_merge(['max:100'], PasswordRules::register($data['email'] ?? null))

         $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')],
            'password' => ['required', 'confirmed', 'min:5'],
            'terms' => ['required', 'in:1'],
            'g-recaptcha-response' => ['required_if:captcha_status,true', new Captcha], [
                'terms.required' => __('You must accept the Terms & Conditions.'),
                'g-recaptcha-response.required_if' => __('validation.required', ['attribute' => 'captcha']),
            ]
        ]);

        DB::beginTransaction();

        try {

            $user =  User::create([
                'type' => 'user',
                'name' => strtoupper($request->name),
                'email' => $request->email,
                'password' => $request->password,
                'email_verified_at' => now(),
                'active' => 1,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('frontend.auth.register')->with('error', __('Sila hubungi pihak pengrusan untuk bantuan'));
        }

        event(new UserCreated($user));

        DB::commit();

        auth()->guard()->login($user);
        return redirect()->route(homeRoute())->withFlashSuccess('Akaun berjaya didaftarkan');
    }

    protected function create(array $data)
    {
        abort_unless(config('boilerplate.access.user.registration'), 404);

        return $this->userService->registerUser($data);
    }
}
