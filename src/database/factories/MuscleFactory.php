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
        $lightMax = fake()->numberBetween($lightMin, $max);
        $heavyMin = fake()->numberBetween($min, $max);
        $heavyMax = fake()->numberBetween($heavyMin, $max);

        if($groupId = fake()->randomElement(Group::all('id'))) {
            $groupId = $groupId['id'];
        } else {
            $groupId = null;
        }

        return [
            'group_id' => $groupId,
            'name' => fake()->text('64'),
            'heavy_min' => $heavyMin,
            'heavy_max' => $heavyMax,
            'light_min' => $lightMin,
            'light_max' => $lightMax,
            'fiber_type' => fake()->randomElement(['Rapide', 'Lente']),
            'max' => max($lightMax, $heavyMax),
        ];
    }
}
