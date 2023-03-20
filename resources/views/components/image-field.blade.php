@props([
    'field',
    'fieldName',
    'disabled' => false,
])

<div class="form-control w-full">
    <label for="{{ $field }}" class="label font-bold">
        <span class="label-text">{{ $fieldName }}</span>
    </label>

    <input type="file"
           wire:model.defer="{{ $field }}"
           class="file-input file-input-bordered file-input-success w-full @error($field) file-input-error @enderror"
           id="{{ $field }}"
           {{ $disabled ? 'disabled' : '' }}
    />

    @error($field)
        <label class="label font-bold">
            <span class="label-text-alt error text-error">{{ $message }}</span>
        </label>
    @enderror
</div>
