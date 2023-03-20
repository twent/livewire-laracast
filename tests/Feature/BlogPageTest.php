<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogPageTest extends TestCase
{
    use RefreshDatabase;

    public function testBlogPageIsLoaded(): void
    {
        $response = $this->get(route('blog'));
        $response->assertStatus(200);
    }

    public function testBlogHasPosts(): void
    {
        $post = Post::factory(['title' => 'Title'])->published()->create();

        $response = $this->get(route('blog'));
        $response->assertSee($post->title);
    }
}
