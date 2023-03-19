<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(5),
            'author' => $this->faker->name,
            'thumbnail' => $this->faker->imageUrl(),
            'intro' => $this->faker->realText(128),
            'content' => $this->faker->realText(1024),
            'published_at' => $this->faker->randomElement([now(), null]),
        ];
    }
}
