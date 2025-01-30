<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class Register extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;

    protected $rules = [
        'name' => 'required|string|regex:/^[\pL\s\-]+$/u|max:255', // Solo permite letras, espacios y guiones
        'email' => 'required|string|email:rfc,dns|max:255|unique:users', // Verifica que el email sea único en la tabla users
        'password' => 'required|string|min:8|max:30|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',// Verifica que la contraseña contenga al menos una letra minúscula, una letra mayúscula, un número y un caracter especial
        'password_confirmation' => 'required|string|min:8|max:30|same:password',// Verifica que la confirmación de la contraseña sea igual a la contraseña
    ];
    
    public function render()
    {
        return view('livewire.auth.register');
    }

    public function register()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        $this->dispatchBrowserEvent('alert', ['message' => 'Registration successful. Please login.']);

        return redirect()->route('login');
    }
}
