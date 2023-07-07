<?php

namespace Database\Factories;

use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Muscle>
 */
class MuscleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'group_id' => fake()->randomElement(Group::all('id')),
            'name' => fake()->text('64'),
            'heavy_min' => fake()->numberBetween(1, 25),
            'heavy_max' => fake()->numberBetween(1, 25),
            'light_min' => fake()->numberBetween(1, 25),
            'light_max' => fake()->numberBetween(1, 25),
            'fiber_type' => fake()->realText(255),
            'max' => fake()->numberBetween(1, 25),
        ];
    }
}
