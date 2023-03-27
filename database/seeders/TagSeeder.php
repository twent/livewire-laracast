<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        Tag::factory(50)->create();

        foreach (Post::all() as $post) {
            $tags = Tag::query()->inRandomOrder()->limit(5)->get();

            $post->attachTags($tags);
        }
    }
}
