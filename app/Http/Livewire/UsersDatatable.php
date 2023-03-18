<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Laravel\Scout\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class UsersDatatable extends Component
{
    use WithPagination;

    public ?string $query = null;
    public bool $showActive = true;
    public ?string $sortingField = null;
    public bool $sortIsAsc = true;

    protected $queryString = [
        'query',
        'showActive',
        'sortingField',
        'sortIsAsc',
    ];

    public array $fields = [
        'name' => 'Name',
        'deleted_at' => 'Status',
        'profession' => 'Profession',
        'created_at' => 'Created',
    ];

    public function updatingQuery(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset();
    }

    public function sortBy(string $field): void
    {
        if (! array_key_exists($field, $this->fields)) {
            return;
        }

        if ($this->sortingField === $field) {
            $this->sortIsAsc= !$this->sortIsAsc;
        }

        $this->sortingField = $field;
    }

    public function render(): View
    {
        $users = User::search($this->query);

        if (! $this->showActive) {
            $users = $users->onlyTrashed();
        }

        sleep(1);

        return view('livewire.users-datatable', [
            'users' => $users->when($this->sortingField, function (Builder $query) {
                $query->orderBy(
                    $this->sortingField,
                    $this->sortIsAsc ? 'asc' : 'desc'
                );
            })->paginate(10),
        ]);
    }
}
