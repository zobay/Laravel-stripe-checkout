<?php declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

final class ProductFactory extends Factory
{

    public function definition()
    {
        return [
            'name' => $this->faker->userName,
            'price' => $this->faker->randomDigit(),
        ];
    }
}
