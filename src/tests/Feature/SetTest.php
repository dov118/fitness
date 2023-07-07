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

class SetTest extends TestCase
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
        $set = Set::factory()->for($exercise)->for($equipment)->create();

        // Create fake period
        $period = Period::factory()->create();

        // Create fake type
        $type = Type::factory()->create();

        // Create fake session
        $session = Session::factory()->for($period)->for($type)->hasAttached($set)->create();

        // Update models
        $result = Set::with('exercise')->with('equipment')->with('session')->find($set->id);

        $this->assertTrue($result->exercise->id === $exercise->id);
        $this->assertTrue($result->equipment->id === $equipment->id);
        foreach ($result->session as $item) {
            $this->assertTrue($item->id === $session->id);
        }
    }
}
