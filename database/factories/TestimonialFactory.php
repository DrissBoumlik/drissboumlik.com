<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Testimonial>
 */
class TestimonialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'image' => json_encode([ 'original' => $this->faker->imageUrl(), 'compressed' => $this->faker->imageUrl() ]),
            'content' => $this->faker->paragraph(),
            'author' => $this->faker->name(),
            'position' => $this->faker->words(2, true),
            'active' => $this->faker->boolean(),
            'order' => $this->faker->numberBetween(1, 100),
            'note' => $this->faker->text(),
        ];
    }
}
