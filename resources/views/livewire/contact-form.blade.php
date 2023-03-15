<div class="space-y-4">
    <h1 class="text-3xl font-bold">
        {{ __('Contact form') }}
    </h1>

    @if($successMessage)
        <div class="alert alert-success shadow-lg my-6 transform transition">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>{{ $successMessage }}</span>
            </div>

            <button type="button" wire:click="$set('successMessage', null)">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    @endif

    <form class="space-y-4" wire:submit.prevent="send">
        <div class="space-y-2">
            <div class="form-control w-full">
                <label for="name" class="label font-bold">
                    <span class="label-text">Your name</span>
                </label>
                <input wire:model.lazy="name"
                       class="input input-bordered w-full @error('name') input-error @enderror"
                       id="name" type="text" placeholder="Your Name" />
                @error('name')
                <label class="label font-bold">
                    <span class="label-text-alt error text-error">{{ $message }}</span>
                </label>
                @enderror
            </div>

            <div class="form-control w-full">
                <label for="email" class="label font-bold">
                    <span class="label-text">Email</span>
                </label>
                <input wire:model.lazy="email"
                       class="input input-bordered w-full @error('email') input-error @enderror"
                       id="email" type="email" placeholder="Your Email" />
                @error('email')
                <label class="label font-bold">
                    <span class="label-text-alt error text-error">{{ $message }}</span>
                </label>
                @enderror
            </div>

            <div class="form-control">
                <label for="message" class="label font-bold">
                    <span class="label-text">Message</span>
                </label>
                <textarea wire:model.lazy="message" id="message"
                          class="textarea textarea-bordered
                      @error('message') textarea-error @enderror">
            </textarea>
                @error('message')
                <label class="label font-bold ">
                    <span class="label-text-alt error text-error">{{ $message }}</span>
                </label>
                @enderror
            </div>
        </div>

        <button type="submit"
                wire:target="send"
                wire:loading.attr="disabled"
                wire:loading.class="loading"
                class="btn btn-wide btn-outline btn-success"
        >
            Send
        </button>
    </form>
</div>
