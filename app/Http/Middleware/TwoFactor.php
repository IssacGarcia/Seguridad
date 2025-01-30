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
        if (session()->has('code')) {
            if (now() > session('expires_at')) {
                session()->forget(['email', 'code', 'expires_at']);
                return redirect()->route('login');
            } else if (
                $request->route()->getName() === 'login' ||
                $request->route()->getName() === 'register'
            ) {
                return redirect()->route('two_factor');
            }
        } else if ($request->route()->getName() === 'two_factor') {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
