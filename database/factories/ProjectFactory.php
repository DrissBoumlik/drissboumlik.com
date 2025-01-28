<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
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
            'role' => $this->faker->word(),
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'featured' => $this->faker->boolean(),
            'links' => json_encode([ 'repository' => $this->faker->url(), 'website' => $this->faker->url() ]),
            'active' => $this->faker->boolean(),
            'order' => $this->faker->numberBetween(1, 100),
            'note' => $this->faker->text(),
        ];
    }
}
