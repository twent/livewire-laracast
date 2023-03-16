<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class UsersDatatable extends Component
{
    use WithPagination;

    public function render(): View
    {
        return view('livewire.users-datatable', [
            'users' => User::withTrashed()->paginate(10),
        ]);
    }
}
