<?php

namespace Tests\Feature;

use App\Models\Equipment;
use App\Models\Exercise;
use App\Models\File;
use App\Models\Group;
use App\Models\Muscle;
use App\Models\Period;
use App\Models\Session;
use App\Models\Set;
use App\Models\Type;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExerciseTest extends TestCase
{
    use RefreshDatabase;

    protected Model $group;
    protected Collection $muscles;
    protected Collection $files;
    protected Model $exercise;
    protected Model $equipment;
    protected Collection $sets;
    protected Model $period;
    protected Model $type;
    protected Model $session;
    protected Model $result;

    public function setUp(): void
    {
        parent::setUp();

        // Create fake group
        $this->group = Group::factory()->create();

        // Create fake muscles
        $this->muscles = Muscle::factory(10)->for($this->group)->create();

        // Create fake files
        $this->files = File::factory(10)->create();

        // Create fake exercise
        $this->exercise = Exercise::factory()->hasAttached($this->muscles)->hasAttached($this->files)->create();

        // Create fake equipment
        $this->equipment = Equipment::factory()->create();

        // Create fake period
        $this->period = Period::factory()->create();

        // Create fake type
        $this->type = Type::factory()->create();

        // Create fake session
        $this->session = Session::factory()->for($this->period)->for($this->type)->create();

        // Create fake sets
        $this->sets = Set::factory(10)->for($this->exercise)->for($this->equipment)->for($this->session)->create();

        // Update model
        $this->result = Exercise::with('sets')->with('files')->with('muscles')->find($this->exercise->id);
    }

    public function test_the_sets_relation_works()
    {
        foreach ($this->result->sets as $item) {
            $this->assertTrue(in_array($item->id, $this->sets->pluck('id')->toArray()));
        }
    }

    public function test_the_files_relation_works()
    {
        foreach ($this->result->files as $item) {
            $this->assertTrue(in_array($item->id, $this->files->pluck('id')->toArray()));
        }
    }

    public function test_the_muscles_relation_works()
    {
        foreach ($this->result->muscles as $item) {
            $this->assertTrue(in_array($item->id, $this->muscles->pluck('id')->toArray()));
        }
    }
}
