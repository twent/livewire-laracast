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
            <div class="counter">
                <span>{{ $this->count }}</span>

                <button wire:click="increment">+</button>
            </div>
        blade;
    }
}
