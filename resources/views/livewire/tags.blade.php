@pushonce('body-scripts')
    <script>

    </script>
@endpushonce


<div class="flex flex-col gap-4">
    <h3 class="px-4 text-3xl font-bold">{{ __('Tags') }}</h3>

    <div
        id="tags"
        class="px-4 w-full"
        wire:ignore
        x-data
        x-init="new Taggle($el, {
        tags: {{ $tags }},
        onTagAdd: function(event, tag) {
            Livewire.emit('addTag', tag)
        },
        onTagRemove: function(event, tag) {
            Livewire.emit('removeTag', tag)
        }
    })

    Livewire.on('tagAddedOnBackend', tag => {
        console.info(`Tag ${tag} has been added`)
    })

    Livewire.on('tagRemovedOnBackend', tag => {
        console.info(`Tag ${tag} has been removed`)
    })"
    >
    </div>
</div>
