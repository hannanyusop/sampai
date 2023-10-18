<?php

namespace App\Http\Middleware;

use App\Domains\Auth\Models\User;
use Auth;
use Closure;
use Illuminate\Auth\AuthenticationException;
class ApiTokenAuthentication
{

    public function handle($request, Closure $next)
    {
        $apiToken = $request->header('Authorization');


        if ($apiToken) {

            //get only the token
            $apiToken = str_replace('Bearer ', '', $apiToken);

            $user = User::where('api_token', $apiToken)->first();

            if ($user) {
                Auth::login($user);
                return $next($request);
            }
        }

        throw new AuthenticationException('Unauthenticated.');
    }
}
