<?php

namespace Database\Factories;

use App\Models\Equipment;
use App\Models\Exercise;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Set>
 */
class SetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'index' => fake()->numberBetween(1, 20),
            'target' => fake()->numberBetween(6, 25),
            'limit' => fake()->numberBetween(6, 25),
            'min' => fake()->numberBetween(6, 25),
            'max' => fake()->numberBetween(6, 25),
            'left' => fake()->numberBetween(6, 25),
            'left_failure' => fake()->boolean(),
            'right' => fake()->numberBetween(6, 25),
            'right_failure' => fake()->boolean(),
            'weight' => fake()->randomFloat(2, 1.5, 70),
            'comment' => fake()->realText(),
            'equipment_id' => fake()->randomElement(Equipment::all('id')),
            'exercise_id' => fake()->randomElement(Exercise::all('id')),
        ];
    }
}
