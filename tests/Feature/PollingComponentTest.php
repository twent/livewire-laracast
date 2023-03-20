<?php

namespace Tests\Feature;

use App\Http\Livewire\Polling;
use App\Models\Order;
use Database\Seeders\OrderSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PollingComponentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(OrderSeeder::class);
    }

    public function testPollingComponentLoaded(): void
    {
        $response = $this->get(route('polling'));

        $response->assertSeeLivewire(Polling::class);

        $sum = Order::query()->sum('price');

        $response->assertSee(number_format($sum, 2, '.', ' '));
    }

    public function testSumChanged(): void
    {
        $componentState = Livewire::test(Polling::class);

        $sum = Order::query()->sum('price');

        $componentState->assertSee(number_format($sum, 2, '.', ' '));

        $order = Order::factory()->create();

        $componentState->call('getRevenue');

        $componentState->assertSee(number_format($sum + $order->price, 2, '.', ' '));
    }
}
