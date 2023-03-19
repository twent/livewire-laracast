<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Post::all() as $post) {
            $comments = Comment::factory(10)->make();
            $post->comments()->saveMany($comments);
        }

    }
}
