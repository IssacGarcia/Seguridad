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
            The password must be at least 8 characters long, one uppercase letter, one lowercase letter, one number, and one symbol.
            </span>
        </div>
    @endif
    
</label>
