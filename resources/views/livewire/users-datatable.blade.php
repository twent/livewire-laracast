<div class="overflow-x-auto w-full space-y-8">
    <h1 class="text-3xl font-bold">{{ __('Users') }}</h1>

    <table class="table table-compact w-full">
        <thead>
            <tr>
                <th>
                    <label>
                        <input type="checkbox" class="checkbox" />
                    </label>
                </th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Profession') }}</th>
                <th>{{ __('Status') }}</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            @forelse($users as $user)
                <tr class="cursor-pointer hover">
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
                        <span class="badge badge-lg badge-success badge-outline p-3 capitalize">
                            {{ $user->profession }}
                        </span>
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
                    <th>
                        <button class="btn btn-ghost btn-xs">details</button>
                    </th>
                </tr>
            @empty
                <tr>
                    {{ __('No content') }}
                </tr>
            @endforelse
        </tbody>

        <tfoot>
        <tr>
            <th></th>
            <th>{{ __('Name') }}</th>
            <th>{{ __('Profession') }}</th>
            <th>{{ __('Status') }}</th>
            <th></th>
        </tr>
        </tfoot>
    </table>

    {{ $users->links() }}
</div>
