<?php

namespace Tests\Feature;

use App\Http\Livewire\PostEditPage;
use App\Models\Post;
use Database\Seeders\PostSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class PostEditTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->seed(PostSeeder::class);
    }

    public function testPostEditPageComponentLoaded(): void
    {
        $post = Post::query()->first();
        $response = $this->get(route('post.edit', $post));
        $response->assertStatus(200);
        $response->assertSeeLivewire(PostEditPage::class);
    }

    public function testPostEditFormWorks(): void
    {
        $post = Post::query()->first();

        $componentState = Livewire::test(PostEditPage::class, [
            'post' => $post
        ]);

        $componentState->set('post.title', $newTitle = 'New title');
        $componentState->set('post.slug', $newSlug = 'custom-slug');

        $componentState->call('save');

        $componentState->assertSee('Post has been updated');
        $componentState->assertSee($newTitle);
        $componentState->assertSee($newSlug);

        $post->refresh();
        $this->assertEquals($newTitle, $post->title);
        $this->assertEquals($newSlug, $post->slug);
    }

    public function testImageUploadWorks(): void
    {
        $post = Post::query()->first();

        $componentState = Livewire::test(PostEditPage::class, [
            'post' => $post
        ]);

        $file = UploadedFile::fake()->image('thumbnail.jpg');

        $componentState->set('thumbnail', $file);
        $componentState->call('save');

        $componentState->assertSee('Post has been updated');

        $post->refresh();
        $this->assertStringContainsString('photos/', $post->getRawOriginal('thumbnail'));
        Storage::disk('public')->assertExists($post->getRawOriginal('thumbnail'));
    }

    public function testDocumentDoesntUploaded(): void
    {
        $post = Post::query()->first();
        $oldThumbnail = $post->thumbnail;

        $componentState = Livewire::test(PostEditPage::class, [
            'post' => $post
        ]);

        $file = UploadedFile::fake()->create('document.pdf', 10);

        $componentState->set('thumbnail', $file);
        $componentState->call('save');

        $componentState->assertHasErrors('thumbnail');
        $componentState->assertSee('The thumbnail field must be an image.');

        $post->refresh();
        $this->assertSame($oldThumbnail, $post->thumbnail);
    }
}
