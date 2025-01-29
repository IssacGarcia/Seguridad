<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Carbon;
use App\Mail\TwoFactorCodeMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class Login extends Component
{
    public $email;
    public $password;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function login()
    {
        $this->validate();

        // Validate the credentials
        if (auth()->validate([
            'email' => $this->email,
            'password' => $this->password,
        ])) {

            // Generate the OTP and store it in the session
            session([
                'email' => $this->email,
                'code' => rand(100000, 999999),
                'expires_at' => Carbon::now()->addMinutes(1),
            ]);

            // Send the email and redirect to the OTP page
            Mail::to($this->email)->send(new TwoFactorCodeMail(session('code')));
            return redirect()->route('two_factor');

        } else {
            $this->dispatchBrowserEvent('alert', ['message' => 'Wrong email or password.']);
        }
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
