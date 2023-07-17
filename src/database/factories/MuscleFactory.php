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
        $min = 4;
        $max = 25;
        $lightMin = fake()->numberBetween($min, $max);
        $lightMax = fake()->numberBetween($lightMin + 1, $max);
        $heavyMin = fake()->numberBetween($min, $max);
        $heavyMax = fake()->numberBetween($heavyMin + 1, $max);

        return [
            'group_id' => fake()->randomElement(Group::all('id')),
            'name' => fake()->text('64'),
            'heavy_min' => $heavyMin,
            'heavy_max' => $heavyMax,
            'light_min' => $lightMin,
            'light_max' => $lightMax,
            'fiber_type' => fake()->randomElement(['Rapide', 'Lente']),
            'max' => $max,
        ];
    }
}
