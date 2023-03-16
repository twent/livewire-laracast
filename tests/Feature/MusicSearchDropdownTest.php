<?php

namespace Tests\Feature;

use App\Http\Livewire\MusicSearchDropdown;
use Livewire\Livewire;
use Tests\TestCase;

class MusicSearchDropdownTest extends TestCase
{
    public function testComponentIsLoaded(): void
    {
        $this
            ->get(route('home'))
            ->assertSeeLivewire(MusicSearchDropdown::class);
    }

    public function testMusicSearchIsFindingTheResult(): void
    {
        $componentState = Livewire::test(MusicSearchDropdown::class);

        $componentState->set('query', 'КИШ');

        $componentState->assertSee('Прыгну со скалы');

        $componentState->set('query', '');

        $componentState->assertDontSee('Прыгну со скалы');
    }
}
