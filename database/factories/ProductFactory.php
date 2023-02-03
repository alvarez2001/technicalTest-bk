<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'reference' => $this->faker->imei(),
            'category' => $this->faker->name(),
            'price' => $this->faker->randomDigit() * 10,
            'weight' => $this->faker->randomDigit(),
            'stock' => $this->faker->randomDigit() * 2
        ];
    }
}
