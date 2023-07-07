<?php

namespace Tests\Feature;

use App\Models\Equipment;
use App\Models\Exercise;
use App\Models\File;
use App\Models\Group;
use App\Models\Muscle;
use App\Models\Set;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExerciseTest extends TestCase
{
    use RefreshDatabase;

    public function test_relations_works()
    {
        // Create fake group
        $group = Group::factory()->create();

        // Create fake muscles
        $muscles = Muscle::factory(10)->for($group)->create();

        // Create fake files
        $files = File::factory(10)->create();

        // Create fake exercise
        $exercise = Exercise::factory()->hasAttached($muscles)->hasAttached($files)->create();

        // Create fake equipment
        $equipment = Equipment::factory()->create();

        // Create fake set
        $sets = Set::factory(10)->for($exercise)->for($equipment)->create();

        // Update models
        $result = Exercise::with('sets')->with('files')->with('muscles')->find($exercise->id);

        foreach ($result->sets as $item) {
            $this->assertTrue(in_array($item->id, $sets->pluck('id')->toArray()));
        }

        foreach ($exercise->files as $item) {
            $this->assertTrue(in_array($item->id, $files->pluck('id')->toArray()));
        }

        foreach ($exercise->muscles as $item) {
            $this->assertTrue(in_array($item->id, $muscles->pluck('id')->toArray()));
        }
    }
}
