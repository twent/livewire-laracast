<div class="hidden md:flex items-center">
    <div class="relative transition-all transform ease-in-out duration-150">
        <!-- Search field -->
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input wire:model.debounce.400ms="query"
                   type="search"
                   autocomplete="off"
                   spellcheck="false"
                   placeholder="{{ __('Search music...') }}"
                   class="relative input input-ghost w-full input-sm border-0 focus:outline-none sm:text-sm"
            />
        </div>

        <!-- Results dropdown -->
        @if($results)
            <ul class="absolute z-50 bg-white border border-gray-100 rounded-md mt-5 text-gray-700 text-sm divide-y divide-gray-200 shadow-md text-opacity-95 transition-all transform">
                @forelse($results as $song)
                    <li>
                        <a href="{{ $song['trackViewUrl'] ?? '' }}" target="_blank" class="flex items-center px-4 py-4 hover:bg-gray-100 transition ease-in-out duration-150">
                            <img src="{{ $song['artworkUrl60'] ?? '' }}" alt="Cover">
                            <div class="ml-4 leading-tight">
                                <div class="font-semibold">{{ $song['trackName'] ?? '' }}</div>
                                <div class="text-gray-600">{{ $song['artistName'] ?? '' }}</div>
                            </div>
                        </a>
                    </li>
                @empty
                    <li class="px-4 py-4">{{ __('Results not found') }}</li>
                @endforelse
            </ul>
        @endif
    </div>
</div>
