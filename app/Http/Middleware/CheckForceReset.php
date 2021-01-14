<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckForceReset
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->needsToResetPassword()) {
            return $this->forceResetPassword($request);
        } 

        return $next($request);
    }

    private function forceResetPassword(Request $request)
    {
        $token = app(\Illuminate\Auth\Passwords\PasswordBroker::class)->createToken($request->user());
        return redirect()->route('password.reset',['token' => $token, 'email' => $request->user()->email]);
    }
}
