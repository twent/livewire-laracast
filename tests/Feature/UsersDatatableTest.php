<?php

namespace Tests\Feature;

use App\Http\Livewire\UsersDatatable;
use App\Models\Profession;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class UsersDatatableTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function testUsersPageIsAvailable(): void
    {
        $response = $this->get(route('users'));

        $response->assertStatus(200);
    }

    public function testUsersDatatableIsLoaded(): void
    {
        $response = $this->get(route('users'));

        $response->assertSeeLivewire(UsersDatatable::class);
    }

    public function testActiveCheckboxWorksFine(): void
    {
        $user = User::factory()->create();
        $deletedUser = User::factory()->deleted()->create();

        $componentState = Livewire::test(UsersDatatable::class);

        $componentState->assertSee($user->name);
        $componentState->assertDontSee($deletedUser->name);

        $componentState->set('showActive', false);
        $componentState->assertSee($deletedUser->name);
        $componentState->assertDontSee($user->name);
    }

    public function testSearchByUsernameWorksFine(): void
    {
        $user = User::factory(['name' => 'Ivan'])->create();
        $user2 = User::factory(['name' => 'Yaroslav'])->create();

        $componentState = Livewire::test(UsersDatatable::class);

        $componentState->set('query', $user->name);
        $componentState->assertSee($user->name);
        $componentState->assertDontSee($user2->name);

        $componentState->set('query', $user2->name);
        $componentState->assertSee($user2->name);
        $componentState->assertDontSee($user->name);
    }

    public function testSearchByEmailWorksFine(): void
    {
        $user = User::factory(['email' => 'z@test.ru'])->create();
        $user2 = User::factory(['email' => 'a@test.ru'])->create();

        $componentState = Livewire::test(UsersDatatable::class);

        $componentState->set('query', $user->email);
        $componentState->assertSee($user->email);
        $componentState->assertDontSee($user2->email);

        $componentState->set('query', $user2->email);
        $componentState->assertSee($user2->email);
        $componentState->assertDontSee($user->email);
    }

    public function testSearchByProfessionWorksFine(): void
    {
        $user = User::factory(['profession' => Profession::Actor->value])->create();
        $user2 = User::factory(['profession' => Profession::Designer->value])->create();

        $componentState = Livewire::test(UsersDatatable::class);

        $componentState->set('query', $user->profession->value);
        $componentState->assertSee($user->profession);
        $componentState->assertDontSee($user2->profession);

        $componentState->set('query', $user2->profession->value);
        $componentState->assertSee($user2->profession);
        $componentState->assertDontSee($user->profession);
    }

    public function testSortingByNameWorksFine(): void
    {
        $user = User::factory(['name' => 'Ivan'])->create();
        $user2 = User::factory(['name' => 'Yaroslav'])->create();

        $componentState = Livewire::test(UsersDatatable::class);

        $componentState->call('sortBy', 'name');
        $componentState->assertSeeInOrder([$user->name, $user2->name]);

        $componentState->call('sortBy', 'name');
        $componentState->assertSeeInOrder([$user2->name, $user->name]);
    }

    public function testSortingByProfessionWorksFine(): void
    {
        $user = User::factory(['profession' => Profession::Actor->value])->create();
        $user2 = User::factory(['profession' => Profession::Designer->value])->create();

        $componentState = Livewire::test(UsersDatatable::class);

        $componentState->call('sortBy', 'profession');
        $componentState->assertSeeInOrder([$user->email, $user2->email]);

        $componentState->call('sortBy', 'profession');
        $componentState->assertSeeInOrder([$user2->email, $user->email]);
    }
}
