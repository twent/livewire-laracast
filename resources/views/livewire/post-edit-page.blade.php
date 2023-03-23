<div class="flex flex-col gap-4 space-y-4">
    <!-- Breadcrumbs -->
    <div class="flex text-sm breadcrumbs items-center gap-6">
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="{{ route('blog') }}">{{ __('Blog') }}</a></li>
            <li><a href="{{ route('post', $post) }}">{{ $post->title }}</a></li>
            <li>{{ __('Edit') }}</li>
        </ul>

        <a class="btn btn-sm gap-2" href="{{ route('post', $post) }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 010 1.06L4.81 8.25H15a6.75 6.75 0 010 13.5h-3a.75.75 0 010-1.5h3a5.25 5.25 0 100-10.5H4.81l4.72 4.72a.75.75 0 11-1.06 1.06l-6-6a.75.75 0 010-1.06l6-6a.75.75 0 011.06 0z" clip-rule="evenodd" />
            </svg>

            {{ __('See post') }}
        </a>
    </div>

    <h1 class="text-3xl font-bold">Editing post "{{ $post->title }}"</h1>

    <form wire:submit.prevent="save" method="post" enctype="multipart/form-data" class="flex flex-col gap-4">
        @csrf
        @method('PATCH')

        <div class="flex flex-col lg:flex-row gap-4 lg:space-x-4 items-start">
            <div class="flex flex-col gap-4 w-full lg:w-1/2 min-w-max">
                <x-text-field field="post.title" fieldName="Title" />
                <x-text-field field="post.author" fieldName="Author" />
                <x-text-field field="post.slug" fieldName="Slug" />
            </div>

            <div
                x-data="{ isUploading: false, progress: 0 }"
                x-on:livewire-upload-start="isUploading = true"
                x-on:livewire-upload-finish="isUploading = false"
                x-on:livewire-upload-error="isUploading = false"
                x-on:livewire-upload-progress="progress = $event.detail.progress"
                class="flex flex-col gap-4 w-full lg:w-1/2">
                <x-image-field field="thumbnail" fieldName="Thumbnail" />

                <!-- Progress Bar -->
                <div x-show="isUploading">
                    <progress class="progress progress-success" max="100" x-bind:value="progress"></progress>
                </div>

                @if($temporaryUrl)
                    <img class="max-w-sm" src="{{ $temporaryUrl }}" alt="{{ $post->title }}">
                @elseif($post->thumbnail)
                    <img class="max-w-sm" src="{{ $post->thumbnail }}" alt="{{ $post->title }}">
                @endif
            </div>
        </div>

        <x-text-field field="post.intro" fieldName="Intro" />
        <x-textarea field="post.content" fieldName="Content" />
        <x-datetime-field field="post.published_at" fieldName="Publish date" />

        <!-- Success message -->
        <x-success-message />

        <!-- Submit button -->
        <button type="submit"
            wire:target="save"
            wire:loading.attr="disabled"
            wire:loading.class="loading"
            class="mt-4 gap-4 btn w-full lg:w-1/3 btn-outline btn-success items-center self-end"
        >
            <svg wire:loading.class="hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
            </svg>
                <span wire:loading.class.remove="hidden" class="hidden">{{ __('Saving...') }}</span>
                <span wire:loading.class="hidden">{{ __('Save') }}</span>
        </button>
    </form>
</div>
