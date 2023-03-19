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
                        <div class="mb-4">
                            <a href="#" class="">
                                <span class="text-base">{{ $post->author }}</span>
                            </a>
                            <a href="{{ route('post', $post) }}">
                                <h2 class="card-title text-xl">{{ $post->title }}</h2>
                            </a>
                        </div>
                        <p>{{ $post->intro }}</p>
                        <div class="card-actions justify-between items-center mt-2">
                            <div class="flex gap-2 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ $post->created_at->diffForHumans() }}</span>
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
