<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Contracts\View\View;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = Post::query()->paginate(9);

        return view('blog.index', [
            'posts' => $posts,
        ]);
    }

    public function show(Post $post): View
    {
        $post->load('comments');

        return view('blog.show', [
            'post' => $post,
        ]);
    }
}
