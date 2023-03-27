@pushonce('head-scripts')
    @vite('resources/js/taggle.js')
@endpushonce

<x-app-layout>
    <div class="flex flex-col gap-4 space-y-4">
        <!-- Breadcrumbs -->
        <div class="text-sm breadcrumbs">
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="{{ route('blog') }}">{{ __('Blog') }}</a></li>
                <li>{{ $post->title }}</li>
            </ul>
        </div>

        <!-- Hero -->
        <div class="hero" style="background-image: url({{ $post->thumbnail }});">
            <div class="hero-overlay bg-opacity-70 backdrop-blur-sm"></div>
            <div class="hero-content text-center text-neutral-content">
                <div class="max-w-lg my-12 space-y-8">
                    <div class="flex items-center gap-8 justify-center">
                        <a href="#" class="flex gap-2 items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>

                            <span class="text-base">{{ $post->author }}</span>
                        </a>

                        <div class="flex gap-2 items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ $post->published_at->diffForHumans() }}</span>
                        </div>

                        <a href="{{ route('post.edit', $post) }}" class="btn gap-2 btn-sm shadow-md">
                            {{ __('Edit') }}
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z" />
                            </svg>
                        </a>
                    </div>

                    <h1 class="text-5xl font-bold">{{ $post->title }}</h1>

                    <p class="max-w-md mx-auto">{{ $post->intro }}</p>
                </div>
            </div>
        </div>

        <p class="px-4 indent-10 leading-7">{{ $post->content }}</p>

        <livewire:tags :post="$post" />

        <livewire:comments :post="$post" />
    </div>
</x-app-layout>
