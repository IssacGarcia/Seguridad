<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TwoFactor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the session has the code
        if (session()->has('code')) {
            if (now() > session('expires_at')) {
                session()->forget(['email', 'code', 'expires_at']);
                return redirect()->route('login');//if the code has expired

                //
            } else if (
                $request->route()->getName() === 'login' ||//if the user is already logged in
                $request->route()->getName() === 'register'//if the user is already registered
            ) {
                return redirect()->route('two_factor');//redirect to the two-factor authentication page
            }
        } else if ($request->route()->getName() === 'two_factor') {
            return redirect()->route('login');//if the user is not logged in
        }

        return $next($request);
    }
}
