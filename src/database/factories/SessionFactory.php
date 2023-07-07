<?php

namespace Database\Factories;

use App\Models\Period;
use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Session>
 */
class SessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type_id' => fake()->randomElement(Type::all('id')),
            'date' => fake()->dateTime(),
            'order' => fake()->numberBetween(1, 6),
            'period_id' => fake()->randomElement(Period::all('id')),
        ];
    }
}
