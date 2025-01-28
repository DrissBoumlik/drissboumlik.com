<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Visitor>
 */
class VisitorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ip' => $this->faker->ipv4(),
            'countryName' => $this->faker->country(),
            'currencyCode' => $this->faker->currencyCode(),
            'countryCode' => $this->faker->countryCode(),
            'regionCode' => $this->faker->citySuffix(),
            'regionName' => $this->faker->city(),
            'cityName' => $this->faker->city(),
            'zipCode' => $this->faker->postcode(),
            'postalCode' => $this->faker->postcode(),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'metroCode' => $this->faker->postcode(),
            'timezone' => $this->faker->timezone(),
            'url' => $this->faker->url(),
        ];
    }
}
