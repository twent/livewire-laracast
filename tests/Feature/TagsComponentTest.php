<?php

namespace Tests\Feature;

use App\Http\Livewire\Tags;
use App\Models\Post;
use Database\Seeders\PostSeeder;
use Database\Seeders\TagSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class TagsComponentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([
            PostSeeder::class,
            TagSeeder::class,
        ]);
    }

    public function testTagsComponentLoaded(): void
    {
        $post = Post::query()->first();

        $response = $this->get(route('post', $post));
        $response->assertStatus(200);
        $response->assertSeeLivewire(Tags::class);
    }

    public function testLoadsExistingTags(): void
    {
        $post = Post::with('tags')->first();

        $componentState = Livewire::test(Tags::class, [
            'post' => $post
        ]);

        $componentState->assertSee(
            $post->tags->pluck('title')
        );
    }

    public function testNewTagsSuccessfullyAdded(): void
    {
        $post = Post::with('tags')->first();

        $componentState = Livewire::test(Tags::class, [
            'post' => $post
        ]);

        $componentState->emit('addTag', 'Tag 1')
            ->assertEmitted('tagAddedOnBackend', 'Tag 1');

        $componentState->emit('addTag', 'Tag 2')
            ->assertEmitted('tagAddedOnBackend', 'Tag 2');

        $post->refresh();

        $this->assertDatabaseHas('tags', ['title' => 'Tag 1']);
        $this->assertDatabaseHas('tags', ['title' => 'Tag 2']);
    }

    public function testTagsSuccessfullyRemoved(): void
    {
        $post = Post::with('tags')->first();

        $componentState = Livewire::test(Tags::class, [
            'post' => $post
        ]);

        foreach ($post->tags as $tag) {
            $this->assertDatabaseHas('taggables', [
                'tag_id' => $tag->id,
                'taggable_type' => 'App\Models\Post',
                'taggable_id' => $post->id
            ]);
        }

        $tags = $post->tags->pluck('title');

        foreach ($tags as $tag) {
            $componentState->emit('removeTag', $tag)
                ->assertEmitted('tagRemovedOnBackend', $tag);
        }

        foreach ($post->tags as $tag) {
            $this->assertDatabaseMissing('taggables', [
                'tag_id' => $tag->id,
                'taggable_type' => 'App\Models\Post',
                'taggable_id' => $post->id
            ]);
        }
    }
}
