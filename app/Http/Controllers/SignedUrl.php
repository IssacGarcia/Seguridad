<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class SignedUrl extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if ($this->isUsed($request)) {
            return abort(403, 'This signed URL has already been used.');
        }
        $this->markUsed($request);
        $action = $request->input('action');

        // Handle the action
        if ($action === 'login') {
            $email = $request->input('email'); // Retrieve email from the request
            $user = User::where('email', $email)->first(); // Find user by email

            if ($user) {
                Auth::login($user, true); // Log in the user
                return redirect()->route('home'); // Redirect to the home/dashboard page
            }
        } else {
            return abort(403, 'Unrecognized action.');
        }
    }

    /**
     * Generate a signed route with an expiration date
     */
    public static function generate(string $action, array $data): string
    {
        $data['action'] = $action;
        $data['token'] = uniqid('signed-url');
        return URL::temporarySignedRoute('signed-url', now()->addMinutes(3), $data);
    }

    /**
     * Mark a signed route as used using the cache
     */
    private function markUsed(Request $request): void
    {
        $token = $request->input('token');
        $expires = $request->input('expires');
        Cache::put('signed-url-'.$token, true, now()->diffInMinutes($expires));
    }

    /**
     * Check if a signed route has already been used
     */
    private function isUsed(Request $request): bool
    {
        $token = $request->input('token');
        return Cache::has('signed-url-'.$token);
    }
}
