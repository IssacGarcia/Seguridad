<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class Register extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $recaptcha;

    // Rules for validation
    protected $rules = [
        'name' => 'required|string|regex:/^[\pL\s\-]+$/u|min:8|max:255', // Unicode letters, spaces, and hyphens
        'email' => 'required|string|email:rfc,dns|max:255|unique:users', // RFC-compliant email address
        'password' => 'required|string|min:8|max:30|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',//password must contain at least one uppercase, one lowercase, one number and one special character
        'password_confirmation' => 'required|string|min:8|max:30|same:password', // Password confirmation must match the password
        'recaptcha' => 'required', // reCAPTCHA is required
    ];

    // Listeners for reCAPTCHA
    protected $listeners = [
        'recaptchaVerified',
        'recaptchaExpired',
    ];

    // Function to verify reCAPTCHA
    public function recaptchaVerified($token)
    {
        $this->recaptcha = $token;
        $this->resetErrorBag('recaptcha');
    }
    // Function to handle expired reCAPTCHA
    public function recaptchaExpired()
    {
        $this->recaptcha = null;
        $this->addError('recaptcha', 'reCAPTCHA expired. Please try again.');
    }
    // Function to register a new user
    public function register()
    {
        $this->validate();

        // Veryfing the reCAPTCHA for Google
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $this->recaptcha,
        ]);
         // If reCAPTCHA verification fails
        if (!$response->json('success')) {
            $this->addError('recaptcha', 'reCAPTCHA verification failed. Please try again.');
            return;
        }

        // Create a new user
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);
        // Show an alert and redirect to the login page
        $this->dispatchBrowserEvent('alert', ['message' => 'Registration successful. Please login.']);

        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
