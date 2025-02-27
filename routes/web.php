<?php

use App\Http\Livewire\Home;
use App\Http\Livewire\Auth\Login;
use App\Http\Controllers\SignedUrl;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\Auth\TwoFactor;
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

Route::get('/', Home::class)->name('index');
Route::get('signed-url', SignedUrl::class)->middleware('signed')->name('signed-url');

Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
    Route::get('/two_factor', TwoFactor::class)->middleware('signed')->name('two_factor');
});

Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('index');
})->middleware('auth')->name('logout');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', Home::class)->name('home');
});
