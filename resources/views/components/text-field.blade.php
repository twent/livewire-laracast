@props([
    'field',
    'fieldName',
    'disabled' => false,
])

<div class="form-control w-full">
    <label for="{{ $field }}" class="label font-bold">
        <span class="label-text">{{ $fieldName }}</span>
    </label>

    <input wire:model.defer="{{ $field }}"
           value="{{ old($field) }}"
           class="input input-bordered w-full @error($field) input-error @enderror"
           id="{{ $field }}" type="text" placeholder="{{ $fieldName }}"
            {{ $disabled ? 'disabled' : '' }}
    />

    @error($field)
        <label class="label font-bold">
            <span class="label-text-alt error text-error">{{ $message }}</span>
        </label>
    @enderror
</div>
