<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->text(),
            'cover' => (object) [ 'original' => $this->faker->imageUrl(), 'compressed' => $this->faker->imageUrl() ],
            'color' => $this->faker->hexColor(),
            'active' => $this->faker->boolean(),
        ];
    }
}
