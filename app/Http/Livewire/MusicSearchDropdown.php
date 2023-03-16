<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class MusicSearchDropdown extends Component
{
    public string $query = '';
    public array $results = [];

    public function updatedQuery()
    {
        if (strlen($this->query) <= 2) {
            $this->results = [];
            return;
        }

        $response = Http::get('https://itunes.apple.com/search', [
            'term' => $this->query,
            'limit' => 5,
        ]);

        $this->results = $response->json('results');
    }

    public function render(): View
    {
        return view('livewire.music-search-dropdown');
    }
}
