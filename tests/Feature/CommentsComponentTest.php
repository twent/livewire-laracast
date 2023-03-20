<?php

namespace Tests\Feature;

use App\Http\Livewire\Comments;
use App\Models\Post;
use Database\Seeders\CommentSeeder;
use Database\Seeders\PostSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CommentsComponentTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([
            PostSeeder::class,
            CommentSeeder::class,
        ]);
    }

    public function testCommentsComponentLoaded(): void
    {
        $post = Post::query()->first();

        $response = $this->get(route('post', $post));
        $response->assertStatus(200);
        $response->assertSeeLivewire(Comments::class);
    }

    public function testValidCommentHasBeenSent(): void
    {
        $post = Post::query()->first();

        $componentState = Livewire::test(Comments::class, [
            'post' => $post,
            'author' => $author = $this->faker->name,
            'text' => $text = $this->faker->realText(1024),
        ]);

        $componentState->call('add');
        $componentState->assertSee('Your comment has been sent!');
        $componentState->assertSee($author);
        $componentState->assertSee($text);
    }

    public function testEmptyCommentDoesntSent(): void
    {
        $post = Post::query()->first();

        $componentState = Livewire::test(Comments::class, [
            'post' => $post,
        ]);

        $componentState->call('add');

        $componentState->assertHasErrors([
            'author' => 'required',
            'text' => 'required'
        ]);

        $componentState->assertSee('The author field is required.');
        $componentState->assertSee('The text field is required.');
    }

    public function testInvalidCommentDoesntSent(): void
    {
        $post = Post::query()->first();

        $componentState = Livewire::test(Comments::class, [
            'post' => $post,
            'author' => $author = 'xx',
            'text' => $text = 'fail',
        ]);

        $componentState->call('add');

        $componentState->assertHasErrors([
            'author' => 'min',
            'text' => 'min'
        ]);

        $componentState->assertSee('The author field must be at least 4 characters.');
        $componentState->assertSee('The text field must be at least 5 characters.');

        $componentState->assertDontSee($author);
        $componentState->assertDontSee($text);
    }
}
