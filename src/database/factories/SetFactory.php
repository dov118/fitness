<?php

namespace Database\Factories;

use App\Models\Equipment;
use App\Models\Exercise;
use App\Models\Session;
use Carbon\Carbon;
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
        $session = Session::with('sets')->find(fake()->randomElement(Session::all('id')))->first();
        $start = Carbon::make($session->date)->add('minutes', fake()->numberBetween(0, 75));
        $duration = fake()->randomFloat(2, 0, 300);

        $warmSession = fake()->boolean(50);
        $warmSet = fake()->boolean($warmSession ? 0 : 50);
        $rest = fake()->boolean($warmSet || $warmSession ? 0 : 50);

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
            'session_id' => $session->id,
            'order' => $session->sets->max('order') + 1,
            'start' => $start,
            'stop' => $start->add('seconds', $duration),
            'duration' => $duration,
            'warm_session' => $warmSession,
            'warm_set' => $warmSet,
            'rest' => $rest
        ];
    }
}
