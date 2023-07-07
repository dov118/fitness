<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipment>
 */
class EquipmentFactory extends Factory
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
            'weight' => fake()->randomFloat(1, 1.5, 60.0),
            'full2_5' => fake()->numberBetween(0, 2),
            'full5' => fake()->numberBetween(0, 2),
            'full7_5' => fake()->numberBetween(0, 2),
            'empty' => fake()->numberBetween(0, 4),
            'ez' => fake()->numberBetween(0, 1),
            'barre' => fake()->numberBetween(0, 1),
            '0_5' => fake()->numberBetween(0, 8),
            '1_25' => fake()->numberBetween(0, 8),
            '2_5' => fake()->numberBetween(0, 8),
            '5_0' => fake()->numberBetween(0, 4),
        ];
    }
}
