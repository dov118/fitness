<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exercise>
 */
class ExerciseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->text(64),
            'guideline' => fake()->realText(),
            'heavy_min' => fake()->numberBetween(6, 25),
            'heavy_max' => fake()->numberBetween(6, 25),
            'light_min' => fake()->numberBetween(6, 25),
            'light_max' => fake()->numberBetween(6, 25),
            'duration' => fake()->randomFloat(2, 0.5, 3.5),
        ];
    }
}
