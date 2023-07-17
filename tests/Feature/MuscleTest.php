<?php

namespace Tests\Feature;

use App\Models\Exercise;
use App\Models\Group;
use App\Models\Muscle;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MuscleTest extends TestCase
{
    use RefreshDatabase;

    protected float $intensity;

    protected Model $group;
    protected Collection $exercises;
    protected Model $muscle;
    protected Model $result;

    public function test_the_group_relation_works()
    {
        // Create fake group
        $group = Group::factory()->create();

        // Create fake exercises
        $exercises = Exercise::factory(10)->create();

        // Create fake muscle
        $muscle = Muscle::factory()->for($group)->hasAttached($exercises)->create();

        // Update model
        $result = Muscle::with('exercises')->with('group')->find($muscle->id);

        $this->assertTrue($result->group->id === $group->id);
    }

    public function test_the_exercises_relation_works()
    {
        // Create fake group
        $group = Group::factory()->create();

        // Create fake exercises
        $exercises = Exercise::factory(10)->create();

        // Create fake muscle
        $muscle = Muscle::factory()->for($group)->hasAttached($exercises)->create();

        // Update model
        $result = Muscle::with('exercises')->with('group')->find($muscle->id);

        foreach ($result->exercises as $item) {
            $this->assertTrue(in_array($item->id, $exercises->pluck('id')->toArray()));
        }
    }

    public function test_the_intensity_return_correct_value()
    {
        // Create fake group
        $group = Group::factory()->create();

        // Create fake exercises
        $exercises = Exercise::factory(10)->create();

        // Create fake muscle
        $muscle = Muscle::factory()->for($group)->hasAttached($exercises)->create();

        // Update model
        Muscle::with('exercises')->with('group')->find($muscle->id);

        $intensity = fake()->randomFloat(2, 0, 1);
        foreach ($exercises as $exercise) {
            $muscle->exercises()->updateExistingPivot($exercise->id, ['intensity' => $intensity]);
        }

        foreach ($exercises as $exercise) {
            $this->assertTrue($exercise->muscles()->first()->pivot->intensity === $intensity);
        }
    }
}
