<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
final class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     * @return array
     */
    public function definition(): array
    {
        return [
            'title'     => fake()->title,
            'content'   => fake()->text,
            'media_url' => fake()->word,
            'author_id' => fake()->randomNumber(),
        ];
    }
}
