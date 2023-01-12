<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'store_id' => $this->faker->numberBetween(1, 10),
            'name' => $this->faker->unique()->name(),
            'address' => $this->faker->address(),
            'description' => $this->faker->paragraph()
        ];
    }
}
