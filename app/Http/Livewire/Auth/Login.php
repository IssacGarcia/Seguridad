<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Carbon;
use App\Mail\TwoFactorCodeMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

class Login extends Component
{
    public $email;
    public $password;
    public $recaptcha;

    //rules for validation
    protected $rules = [
        'email' => 'required|email:rfc,dns|max:50|exists:users,email', //check if email exists in the database
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

            // Generate the OTP and store it in the session
            session([
                'email' => $this->email,
                'code' => rand(100000, 999999),
                'expires_at' => Carbon::now()->addMinutes(3),
            ]);

            // Send the email and redirect to the OTP page
            Mail::to($this->email)->send(new TwoFactorCodeMail(session('code')));
            return redirect()->route('two_factor');
        

        
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
