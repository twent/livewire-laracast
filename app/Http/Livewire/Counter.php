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
        return <<<blade
            <div class="counter flex items-center gap-2 text-3xl font-bold">
                <span class="-mt-1">{{ $this->count }}</span>

                <button class="btn btn-sm btn-outline" wire:click="increment">+</button>
            </div>
        blade;
    }
}
