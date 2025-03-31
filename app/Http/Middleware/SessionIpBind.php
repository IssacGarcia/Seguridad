<?php

namespace App\Http\Middleware;

use Closure;

class SessionIpBind
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        // Get the current IP address and User-Agent of the client
        $ip = $request->ip();
        $userAgent = $request->header('User-Agent');

        // Retrieve the stored IP and User-Agent from the session
        $sessionIp = session('ip_address');
        $sessionUserAgent = session('user_agent');

        // Check if the IP or User-Agent have changed
        if (($sessionIp && $sessionIp !== $ip) || ($sessionUserAgent && $sessionUserAgent !== $userAgent)) {
            auth()->logout();  // Log the user out if either IP or User-Agent changes
            session()->flush();  // Clear the session data
            return redirect()->route('login');  // Redirect to the login page
        }

        // Store the IP address and User-Agent in the session if not already set
        if (!$sessionIp) {
            session(['ip_address' => $ip]);
        }
        if (!$sessionUserAgent) {
            session(['user_agent' => $userAgent]);
        }

        return $next($request);
    }
}