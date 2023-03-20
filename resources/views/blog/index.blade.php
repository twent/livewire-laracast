<x-app-layout>
    <div class="flex flex-col gap-4 space-y-8">
        <!-- Breadcrumbs -->
        <div class="text-sm breadcrumbs">
            <ul>
                <li><a href="/">Home</a></li>
                <li>{{ __('Blog') }}</li>
            </ul>
        </div>

        <h1 class="text-3xl font-bold text-center">Blog</h1>

        <div class="flex flex-wrap gap-6 justify-center">
            @foreach($posts as $post)
                <div class="card w-[22rem] bg-base-100 shadow-xl">
                    <a href="{{ route('post', $post) }}">
                        <figure class="rounded-t-box">
                            <img src="{{ $post->thumbnail }}" alt="{{ $post->title }}">
                        </figure>
                    </a>
                    <div class="card-body">
                        <div class="mb-4 flex gap-4 justify-between items-start">
                            <div>
                                <a href="#" class="">
                                    <span class="text-base">{{ $post->author }}</span>
                                </a>
                                <a href="{{ route('post', $post) }}">
                                    <h2 class="card-title text-xl">{{ $post->title }}</h2>
                                </a>
                            </div>

                            <a href="{{ route('post.edit', $post) }}" class="btn btn-square btn-sm btn-ghost btn-warning">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-gray-700">
                                    <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z" />
                                </svg>
                            </a>
                        </div>
                        <p>{{ $post->intro }}</p>
                        <div class="card-actions justify-between items-center mt-2">
                            <div class="flex gap-2 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ $post->published_at->diffForHumans() }}</span>
                            </div>
                            <a href="{{ route('post', $post) }}" class="btn btn-outline btn-success">Read</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{ $posts->links() }}
    </div>
</x-app-layout>
