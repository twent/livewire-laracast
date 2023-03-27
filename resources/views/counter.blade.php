@pushonce('body-scripts')
    <script>
        // find all elements with wire:snapshot
        // go through each, pull out the string of data
        // turn that string into an actual JS object
        document.querySelectorAll('[wire\\:snapshot]').forEach(el => {
            let snapshot = JSON.parse(el.getAttribute('wire:snapshot'))

            el.addEventListener('click', e => {
                if (! e.target.hasAttribute('wire:click')) return

                let method = e.target.getAttribute('wire:click')

                //working with wire:click elements
                fetch('/livewire', {
                    method: 'POST',
                    headers: { 'Content-Type' : 'application/json' },
                    body: JSON.stringify({
                        _token: '{{ csrf_token() }}',
                        method,
                        snapshot
                    })
                })
            })
        })
    </script>
@endpushonce

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Counter') }}
        </h2>
    </x-slot>

    @livewire(\App\Http\Livewire\Counter::class)
    {{--    <livewire:counter/>--}}
</x-app-layout>
