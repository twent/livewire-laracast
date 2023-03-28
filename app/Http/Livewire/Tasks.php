<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use Livewire\Component;

class Tasks extends Component
{
    public ?string $draft = '';
    public array $tasks = [];

    public function mount()
    {
        $this->tasks = ['Task 1', 'Task 2'];
    }

    public function updatedDraft()
    {
        $this->draft = mb_convert_case($this->draft, MB_CASE_TITLE);
    }

    public function createTask(): void
    {
        $this->tasks[] = $this->draft;
        $this->draft = '';
    }

    public function render(): string
    {
        return <<<'HTML'
            <div class="todos flex flex-col gap-12">
                <h1 class="text-3xl font-bold">Tasks list</h1>

                <div class="flex gap-4">
                    <div class="form-control w-full">
                        <label class="label sr-only">
                            <span class="label-text">What do you need to do?</span>
                        </label>
                        <input wire:model="draft" class="input input-bordered" placeholder="What is you need to do?" />
                    </div>

                    <button wire:click="createTask" class="btn md:btn-wide btn-success">Add</button>
                </div>

                <div class="flex flex-col gap-4">
                    @foreach($tasks as $task)
                      <div class="border bg-base-100 shadow-xl rounded-box">
                          <div class="flex justify-between gap-4 p-8 ">
                            <h2 class="card-title">{{ $task }}</h2>

                            <div class="flex gap-2 md:gap-3 justify-end">
                              <button class="btn btn-success">Done</button>
                              <button class="btn btn-error">Delete</button>
                            </div>
                          </div>
                      </div>
                    @endforeach
                </div>
            </div>
        HTML;
    }
}
