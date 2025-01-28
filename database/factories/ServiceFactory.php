<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'slug' => $this->faker->unique()->slug(),
            'title' => $this->faker->sentence(),
            'icon' => $this->faker->imageUrl(),
            'image' => json_encode([ 'original' => $this->faker->imageUrl(), 'compressed' => $this->faker->imageUrl() ]),
            'link' => $this->faker->url(),
            'description' => $this->faker->text(),
            'active' => $this->faker->boolean(),
            'order' => $this->faker->numberBetween(1, 100),
            'note' => $this->faker->text(),
        ];
    }
}
