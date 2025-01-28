<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'author_id' => User::inRandomOrder()->first()?->id ?? $this->faker->randomNumber(),
            'title' => $this->faker->text(),
            'slug' => $this->faker->slug(),
            'excerpt' => $this->faker->text(),
            'content' => $this->faker->text(700),
            'cover' => (object) [ 'original' => $this->faker->imageUrl(), 'compressed' => $this->faker->imageUrl() ],
            'description' => $this->faker->text(),
            'published' => $this->faker->boolean(),
            'featured' => $this->faker->boolean(),
            'active' => $this->faker->boolean(),
            'likes' => $this->faker->randomDigit(),
            'views' => $this->faker->randomDigit(),
            'published_at' => $this->faker->date(),
        ];
    }
}
