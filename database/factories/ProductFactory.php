<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->unique()->sentence(),
            'description' => $this->faker->paragraph(),
            'benefits' => $this->faker->sentence(),
            'brand' => $this->faker->sentence(),
            'price' => $this->faker->numberBetween(10000, 100000),
            'store_id' => $this->faker->numberBetween(1, 10),
            'product_id' => $this->faker->numberBetween(1, 10),
            'imageUrl' => $this->faker->imageUrl()
        ];
    }
}
