<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $token = auth()->user()->createToken('API Token')->accessToken;
            return response(['token' => $token], 200);
        } else {
            return response(['error' => 'Unauthorized'], 401);
        }
    }

    public function user(Request $request)
    {
        return response(['user' => $request->user()], 200);
    }

    public function checkAuth(Request $request)
    {
        $user = $request->user();

        if ($user) {
            return response(['authenticated' => true, 'user' => $user], 200);
        } else {
            return response(['authenticated' => false], 401);
        }
    }

    public function logout()
    {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return response(['message' => 'Logged out successfully'], 200);
    }
}
