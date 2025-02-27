<?php

namespace App\Http\Livewire\Auth;

use URL;
use Cache;
use App\Models\OTPCode;
use Livewire\Component;
use App\Mail\SignedLoginMail;
use App\Http\Controllers\SignedUrl;
use App\Mail\TwoFactorCodeMail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class Login extends Component
{
    public $email;
    public $password;
    public $recaptcha;

    //rules for validation
    protected $rules = [
        'email' => 'required|email:rfc,dns|max:50', //check if email exists in the database
        'password' => 'required|string|min:8|max:30|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',//password must contain at least one uppercase, one lowercase, one number and one special character
        'recaptcha' => 'required',//recaptcha is required
    ];

    //listeners for recaptcha
    protected $listeners = [
        'recaptchaVerified'
    ];
    //function to verify recaptcha
    public function recaptchaVerified($response)
    {
        $this->recaptcha = $response;
        $this->resetErrorBag('recaptcha');
    }
    //function to login
    public function login()
    {
        $this->validate();
        //check if recaptcha is valid
        if (!session()->has('recaptcha') || now() > session('recaptcha')) {

            // Verify the reCAPTCHA for Google
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => config('services.recaptcha.secret_key'),
                'response' => $this->recaptcha,
            ]);
            //if recaptcha verification fails
            if (!$response->json('success')) {
                $this->addError('recaptcha', 'The reCAPTCHA verification failed. Please try again.');
                return;
            }
            //store recaptcha in session
            session(['recaptcha' => now()->addMinutes(2)]);
        }

        // Validate the credentials
        if (auth()->validate([
            'email' => $this->email,
            'password' => $this->password,
        ])) {

            // Remove the recaptcha session
            session()->forget('recaptcha');

            // signed url to login
            $otp = OTPCode::createCode($this->email);
            $url = URL::temporarySignedRoute('two_factor', now()->addMinutes(3), ['email' => $this->email]);

            // Send the OTP to the user
            Mail::to($this->email)->send(new TwoFactorCodeMail($otp->code));

            return redirect($url);
        } else {

            //if email or password is wrong
            $this->dispatchBrowserEvent('alert', ['message' => 'Wrong email or password.']);
        }
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
