<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShortenedUrl>
 */
class ShortenedUrlFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'slug' => $this->faker->slug(),
            'title' => $this->faker->title(),
            'shortened' => $this->faker->slug(),
            'redirects_to' => $this->faker->url(),
            'note' => $this->faker->text(),
            'active' => $this->faker->boolean(),
        ];
    }
}
