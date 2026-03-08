<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

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
        $mediaUrl = null;
        
        if (fake()->boolean(30)) {
            $file = UploadedFile::fake()->image('media.jpg', width: 800, height: 600);
            $mediaUrl = $file->store('media', 'public');
        }

        return [
            'title'     => fake()->sentence(),
            'content'   => fake()->paragraphs(3, true),
            'media_url' => $mediaUrl,
            'user_id' => User::factory(),
        ];
    }
}
