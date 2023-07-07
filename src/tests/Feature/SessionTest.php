<?php

namespace Tests\Feature;

use App\Models\Equipment;
use App\Models\Exercise;
use App\Models\Group;
use App\Models\Muscle;
use App\Models\Period;
use App\Models\Session;
use App\Models\Set;
use App\Models\Type;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SessionTest extends TestCase
{
    use RefreshDatabase;

    public function test_relations_works()
    {
        // Create fake group
        $group = Group::factory()->create();

        // Create fake muscles
        $muscles = Muscle::factory()->for($group)->create();

        // Create fake exercise
        $exercise = Exercise::factory()->hasAttached($muscles)->create();

        // Create fake exercise
        $equipment = Equipment::factory()->create();

        // Create fake sets
        $sets = Set::factory(10)->for($exercise)->for($equipment)->create();

        // Create fake period
        $period = Period::factory()->create();

        // Create fake type
        $type = Type::factory()->create();

        // Create fake session
        $session = Session::factory()->for($period)->for($type)->hasAttached($sets)->create();

        // Update models
        $result = Session::with('period')->with('type')->with('sets')->find($session->id)->first();

        $this->assertTrue($type->id === $result->type->id);
        $this->assertTrue($period->id === $result->period->id);
        foreach ($result->sets as $item) {
            $this->assertTrue(in_array($item->id, $sets->pluck('id')->toArray()));
        }
    }
}
