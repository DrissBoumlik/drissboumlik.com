<?php

namespace Database\Factories;

use App\Models\MenuType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'text' => $this->faker->text(),
            'title' => $this->faker->text(),
            'slug' => $this->faker->slug(),
            'target' => $this->faker->randomElement(['_blank', '_self']),
            'link' => $this->faker->url(),
            'icon' => $this->faker->imageUrl(),
            'menu_type_id' => MenuType::inRandomOrder()->first()->id,
            'active' => $this->faker->boolean(),
            'order' => $this->faker->numberBetween(1,10),
        ];
    }
}
