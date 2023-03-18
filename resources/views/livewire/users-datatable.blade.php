<div class="overflow-x-auto w-full space-y-8">
    <h1 class="text-3xl font-bold">{{ __('Users') }}</h1>

    <!-- Filters -->
    <div class="space-y-4">
        <h3 class="text-xl font-bold">{{ __('Filters') }}</h3>

        <!-- Search -->
        <div class="flex items-center justify-between space-x-3">
            <div class="form-control w-1/3 min-w-max">
                <label class="label font-bold">
                    <span class="sr-only">{{ __('Search') }}</span>
                    <input wire:model.debounce.500ms="query" id="search" type="search" placeholder="Search..." class="input input-bordered w-full focus:outline-none" spellcheck="false" autocomplete="off" />
                </label>
                <label class="label">
                    <span class="label-text-alt">
                        {{ __('Searching by name, email or profession') }}
                    </span>
                </label>
            </div>

            <!-- Active/Inactive -->
            <div class="form-control items-center">
                <label for="active" class="cursor-pointer label">
                    <span class="label-text font-bold">Active</span>
                </label>
                <input wire:model="showActive" id="active" type="checkbox" class="checkbox checkbox-success focus:outline-none" />
            </div>
        </div>

        <!-- Reset button -->
        @if($query or !$showActive or $sortingField or !$sortIsAsc)
            <button wire:dirty.class="hidden" wire:click="resetFilters" class="btn btn-md gap-2 btn-warning">
                Reset
            </button>
        @endif
    </div>

    <!-- Table -->
    <table class="table table-compact w-full">
        <thead>
            <tr>
                <th>
                    <label>
                        <input type="checkbox" class="checkbox" />
                    </label>
                </th>
                @foreach($fields as $fieldName => $label)
                    <th>
                        <button wire:click="sortBy('{{ $fieldName }}')" class="btn btn-sm btn-ghost gap-2 items-center">
                            {{ __($label) }}
                            <x-sort-icon
                                :fieldName="$fieldName"
                                :sortingField="$sortingField"
                                :sortIsAsc="$sortIsAsc"
                            />
                        </button>
                    </th>
                @endforeach
                <th>{{ __('Actions') }}</th>
            </tr>
        </thead>

        <tbody>
            <tr wire:loading.delay>
                <td colspan="6">
                    <span class="mx-8 my-12 text-2xl font-bold">{{ __('Loading') }}...</span>
                </td>
            </tr>
            @forelse($users as $user)
                <tr wire:loading.class="hidden" class="cursor-pointer hover">
                    <th>
                        <label>
                            <input type="checkbox" class="checkbox" />
                        </label>
                    </th>
                    <td>
                        <div class="my-1 flex items-center space-x-8">
                            <div class="avatar">
                                <div class="mask mask-circle w-12 h-12">
                                    <img src="{{ $user->avatar }}" alt="avatar" />
                                </div>
                            </div>
                            <div>
                                <div class="text-lg">
                                    {{ $user->name }}
                                </div>
                                <div class="text-sm opacity-70">
                                    {{ $user->email }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($user['deleted_at'])
                            <div class="p-3 badge badge-error">
                                {{ __('Inactive') }}
                            </div>
                        @else
                            <div class="p-3 badge badge-success">
                                {{ __('Active') }}
                            </div>
                        @endif
                    </td>
                    <td>
                        <span class="badge badge-lg badge-success badge-outline p-3 capitalize">
                            {{ $user->profession }}
                        </span>
                    </td>
                    <td>
                        {{ $user->created_at->diffForHumans() }}
                    </td>
                    <th>
                        <button class="btn btn-ghost btn-xs">details</button>
                    </th>
                </tr>
            @empty
                <tr wire:loading.class="hidden">
                    <td colspan="6">
                        <span class="mx-8 my-12 mx-8 my-12 text-2xl font-bold">{{ __('No content') }}</span>
                    </td>
                </tr>
            @endforelse
        </tbody>

        <tfoot>
            <tr>
                <th></th>
                @foreach($fields as $fieldName => $label)
                    <th>
                        <button wire:click="sortBy('{{ $fieldName }}')" class="btn btn-sm btn-ghost gap-2 items-center">
                            {{ __($label) }}
                            <x-sort-icon
                                :fieldName="$fieldName"
                                :sortingField="$sortingField"
                                :sortIsAsc="$sortIsAsc"
                            />
                        </button>
                    </th>
                @endforeach
                <th>{{ __('Actions') }}</th>
            </tr>
        </tfoot>
    </table>

    {{ $users->links() }}
</div>
