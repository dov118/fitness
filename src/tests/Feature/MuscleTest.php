<?php

namespace Tests\Feature;

use App\Models\Exercise;
use App\Models\Group;
use App\Models\Muscle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MuscleTest extends TestCase
{
    use RefreshDatabase;

    public function test_relations_works()
    {
        // Create fake group
        $group = Group::factory()->create();

        // Create fake exercises
        $exercises = Exercise::factory(10)->create();

        // Create fake muscle
        $muscle = Muscle::factory()->for($group)->hasAttached($exercises)->create();

        // Update models
        $result = Muscle::with('exercises')->with('group')->find($muscle->id);

        $this->assertTrue($result->group->id === $group->id);

        foreach ($result->exercises as $item) {
            $this->assertTrue(in_array($item->id, $exercises->pluck('id')->toArray()));
        }
    }
}
