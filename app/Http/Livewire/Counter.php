<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Counter extends Component
{
    public int $count = 0;

    public function increment(): void
    {
        $this->count++;
    }

    public function render(): string
    {
        return <<<'HTML'
            <div class="counter flex flex-col gap-4">
                <h1 class="text-3xl font-bold">Counter</h1>

                <div class="mx-4 flex items-center gap-4">
                    <span class="-mt-1 text-3xl">{{ $count }}</span>

                    <button class="btn btn-sm btn-outline" wire:click="increment">+</button>
                </div>
            </div>
        HTML;
    }
}
