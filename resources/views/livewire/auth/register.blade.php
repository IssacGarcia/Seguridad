@extends('layouts.app')

@section('title', 'Registro')

@section('content')
<div class="flex justify-center items-center min-h-screen">
    <form wire:submit.prevent="register" class="w-1/3 bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-6">Registro</h2>
        <div class="mb-4">
            <label for="name" class="block mb-2">Nombre</label>
            <input type="text" id="name" wire:model="name" class="w-full border rounded p-2">
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label for="email" class="block mb-2">Correo</label>
            <input type="email" id="email" wire:model="email" class="w-full border rounded p-2">
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label for="password" class="block mb-2">Contraseña</label>
            <input type="password" id="password" wire:model="password" class="w-full border rounded p-2">
            @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label for="password_confirmation" class="block mb-2">Confirmar Contraseña</label>
            <input type="password" id="password_confirmation" wire:model="password_confirmation" class="w-full border rounded p-2">
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Registrarse</button>
    </form>
</div>
@endsection
