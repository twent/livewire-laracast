<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Polling extends Component
{
    public int $revenue;

    public function mount(): void
    {
        $this->revenue = $this->getRevenue() ?? 0;
    }

    public function getRevenue(): ?int
    {
        $this->revenue = Order::query()->sum('price');

        return $this->revenue;
    }

    public function render(): View
    {
        return view('livewire.polling');
    }
}
