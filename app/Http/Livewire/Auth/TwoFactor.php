<?php

namespace App\Http\Livewire\Auth;

use App\Http\Controllers\SignedUrl;
use App\Models\OTPCode;
use App\Models\User;
use Illuminate\Http\Request;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class TwoFactor extends Component
{
    public $email;      // Variable to store the email address
    public $code;       // Variable to store the OTP entered by the user
    public $recaptcha;  // Variable to store the reCAPTCHA token

    //  Validation rules, including reCAPTCHA
    protected $rules = [
        'code' => 'required|numeric|digits:6', // OTP must be exactly 6 digits
        'recaptcha' => 'required', // reCAPTCHA verification is mandatory
    ];

    //  Livewire event listener for reCAPTCHA verification
    protected $listeners = [
        'recaptchaVerified'
    ];

    //  Function to receive the reCAPTCHA token from the frontend
    public function recaptchaVerified($response)
    {
        $this->recaptcha = $response; // Store the token
        $this->resetErrorBag('recaptcha'); // Reset validation errors for reCAPTCHA
    }

    public function mount(Request $request)
    {
        $this->email = $request->query('email');
    }

    //  Renders the Livewire view for two-factor authentication
    public function render()
    {
        return view('livewire.auth.two-factor');
    }

    //  Cancels two-factor authentication and redirects to the login page
    public function cancel()
    {
        return redirect()->route('login'); // Redirect to login page
    }

    //  Confirms the OTP and validates reCAPTCHA before logging in
    public function confirm(Request $request)
    {
        $this->validate(); // Validate the input fields

        // 🔹 Verify the reCAPTCHA with Google API
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'), // Get secret key from config
            'response' => $this->recaptcha, // Send reCAPTCHA token for validation
        ]);

        // 🔹 If reCAPTCHA verification fails, show an error
        if (!$response->json('success')) {
            $this->addError('recaptcha', 'reCAPTCHA verification failed, please try again.');
            return;
        }

        // Find the OTP code by email
        $otp = OTPCode::findByEmail($this->email);

        // 🔹 Validate the OTP code
        if ($otp->validateCode($this->code)) {
            $url = SignedUrl::generate('login', ['email' => $this->email]); // Generate a signed URL
            return redirect($url); // Redirect to the signed URL
        } else {
            // 🔹 Show an error if the OTP is incorrect
            $this->addError('code', 'Invalid OTP code.');
        }
    }
}