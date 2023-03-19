<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'author' => $this->faker->name,
            'text' => $this->faker->realText(1024),
            'published_at' => now(),
        ];
    }
}
