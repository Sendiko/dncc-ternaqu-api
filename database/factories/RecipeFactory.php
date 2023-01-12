<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeFactory extends Factory
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
            'benefit' => $this->faker->sentence(),
            'tools_and_materials' => $this->faker->sentence(),
            'steps' => $this->faker->sentence(),
            'imageUrl' => $this->faker->imageUrl()
        ];
    }
}
