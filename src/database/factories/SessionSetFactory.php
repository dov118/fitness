<?php

namespace Database\Factories;

use App\Models\Session;
use App\Models\Set;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SessionStep>
 */
class SessionSetFactory extends Factory
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

        $warm_session = fake()->boolean(50);
        $warm_set = fake()->boolean($warm_session ? 0 : 50);
        $rest = fake()->boolean($warm_set || $warm_session ? 0 : 50);

        return [
            'session_id' => $session->id,
            'order' => $session->sets->max('order') + 1,
            'start' => $start,
            'stop' => $start->add('seconds', $duration),
            'duration' => $duration,
            'warm_session' => $warm_session,
            'warm_set' => $warm_set,
            'rest' => $rest,
            'set_id' => fake()->randomElement(Set::all('id')),
        ];
    }
}
