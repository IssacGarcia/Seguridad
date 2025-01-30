@props([
    'for',
    'label',
    'type' => 'text',
])

<label class="form-control w-full max-w-xs">
    <div class="label">
        <span class="label-text">{{ $label }}</span>
    </div>
    <input class="input input-bordered w-full max-w-xs"
    wire:model="{{ $for }}" type="{{ $type }}" />
    @error ($for)
        <div class="label">
            <span class="label-text-alt text-error">{{ $message }}</span>
        </div>
    @enderror

    @if ($type === 'password')
        <div class="label">
            <span class="label-text-alt text-gray-500">
                La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un símbolo.
            </span>
        </div>
    @endif
    
</label>
