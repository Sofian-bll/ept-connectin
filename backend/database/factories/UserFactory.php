<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * @extends Factory<User>
 */
final class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     * @return array
     */
    public function definition(): array
    {
        return [
            'name'              => fake()->name,
            'email'             => fake()->safeEmail,
            'email_verified_at' => fake()->optional()->datetime(),
            'password'          => bcrypt(fake()->password),
            'remember_token' => Str::random(10),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (User $user) {
            if (fake()->boolean(80)) {
                $file = UploadedFile::fake()->image('avatar.jpg', width: 200, height: 200);
                $path = $file->storeAs('avatars', $user->id . '.jpg', 'public');
                $user->updateQuietly([ 'avatar' => $path ]);
            }
        });
    }
}
