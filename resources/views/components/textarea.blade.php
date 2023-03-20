@props([
    'field',
    'fieldName',
    'disabled' => false,
])

<div class="form-control w-full">
    <label for="{{ $field }}" class="label font-bold">
        <span class="label-text">{{ $fieldName }}</span>
    </label>

    <textarea
        wire:ignore
        x-data="{ resize: () => { $el.style.height = '5px'; $el.style.height = $el.scrollHeight + 'px' } }"
        x-init="resize()"
        @input="resize()"
        wire:model.defer="{{ $field }}" id="{{ $field }}" class="textarea textarea-bordered textarea-lg h-20 overflow-y-hidden @error($field) textarea-error @enderror" {{ $disabled ? 'disabled' : '' }}>{{ old($field) }}</textarea>

    @error($field)
        <label class="label font-bold">
            <span class="label-text-alt error text-error">{{ $message }}</span>
        </label>
    @enderror
</div>
