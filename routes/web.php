<?php

use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Register;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Ruta para el registro
Route::get('/register', Register::class)->name('register');

// Ruta para el login
Route::get('/login', Login::class)->name('login');

// Ruta protegida para el dashboard (solo accesible después de iniciar sesión)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// Ruta para el cierre de sesión
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

