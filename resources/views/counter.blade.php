<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Counter') }}
        </h2>
    </x-slot>

    @livewire(\App\Http\Livewire\Counter::class)
    {{--    <livewire:counter/>--}}
</x-app-layout>
