<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class TwoFactor extends Component
{
    public $code;

    protected $rules = [
        'code' => 'required|numeric|digits:6',
    ];

    public function render()
    {
        return view('livewire.auth.two-factor');
    }

    public function cancel()
    {
        session()->forget(['email', 'code', 'expires_at']);
        return redirect()->route('login');
    }

    public function confirm()
    {
        $this->validate();

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
            $this->addError('code', 'Invalid code');
        }
    }
}
