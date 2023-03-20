<div class="flex flex-col space-y-8">
    <!-- Comments -->
    <h2 class="ml-4 text-3xl font-bold">{{ __('Add comment:') }}</h2>

    <x-success-message />

    <form class="mx-4 space-y-4" wire:submit.prevent="add">
        <div class="space-y-2">
            <div class="form-control w-full">
                <label for="author" class="label font-bold">
                    <span class="label-text">Your name</span>
                </label>
                <input wire:model.defer="author"
                       value="{{ old('author') }}"
                       class="input input-bordered w-full @error('author') input-error @enderror"
                       id="author" type="text" placeholder="Your Name" />
                @error('author')
                <label class="label font-bold">
                    <span class="label-text-alt error text-error">{{ $message }}</span>
                </label>
                @enderror
            </div>

            <div class="form-control">
                <label for="text" class="label font-bold">
                    <span class="label-text">Comment</span>
                </label>
                <textarea wire:model.defer="text" id="text" class="textarea textarea-bordered @error('text') textarea-error @enderror">{{ old('text') }}</textarea>
                @error('text')
                <label class="label font-bold ">
                    <span class="label-text-alt error text-error">{{ $message }}</span>
                </label>
                @enderror
            </div>
        </div>

        <button type="submit"
                wire:target="add"
                wire:loading.attr="disabled"
                wire:loading.class="loading"
                class="btn btn-wide btn-outline btn-success"
        >
            Add
        </button>
    </form>

    <h2 class="ml-4 text-3xl font-bold">{{ __('Comments:') }}</h2>

    <div class="pb-4 flex flex-wrap gap-8">
        @forelse($comments as $comment)
            <div class="card card-bordered w-full bg-base-100 shadow-xl">
                <div class="card-body gap-6">
                    <div class="flex gap-4 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-12 h-12 text-gray-400">
                            <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" clip-rule="evenodd" />
                        </svg>

                        <div>
                            <h2 class="card-title">{{ $comment->author }}</h2>
                            <span class="text-gray-600">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    <p class="indent-10 leading-7 text-gray-800">
                        {{ $comment->text }}
                    </p>
                </div>
            </div>
        @empty
            <div class="mx-4 w-full flex gap-6 items-center text-xl bg-base-100">
                {{ __('Comments doesn\'t exists') }}
            </div>
        @endforelse
    </div>
</div>
