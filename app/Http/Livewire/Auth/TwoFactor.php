<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class TwoFactor extends Component
{
    public $code;

    // Rules for validation
    protected $rules = [
        'code' => 'required|numeric|digits:6',
    ];
    // Function to render the view
    public function render()
    {
        return view('livewire.auth.two-factor');
    }
    // Function to cancel the two-factor authentication
    public function cancel()
    {
        session()->forget(['email', 'code', 'expires_at']);
        return redirect()->route('login');
    }
    // Function to confirm the two-factor authentication
    public function confirm()
    {
        $this->validate();
        // Check if the code is correct
        if (session('code') == $this->code) {

            // Extract the user from the session
            $email = session('email');
            $user = User::where('email', $email)->first();

            // Perform the login
            session()->forget(['email', 'code', 'expires_at']);
            Auth::login($user, true);

            return redirect()->route('home');
        }
        else {
            // Add an error message if the code is incorrect
            $this->addError('code', 'Invalid code');
        }
    }
}
