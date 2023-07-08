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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SetTest extends TestCase
{
    use RefreshDatabase;

    protected Model $group;
    protected Model $muscle;
    protected Model $exercise;
    protected Model $equipment;
    protected Model $set;
    protected Model $period;
    protected Model $type;
    protected Model $session;
    protected Model $result;

    public function setUp(): void
    {
        parent::setUp();

        // Create fake group
        $this->group = Group::factory()->create();

        // Create fake muscle
        $this->muscle = Muscle::factory()->for($this->group)->create();

        // Create fake exercise
        $this->exercise = Exercise::factory()->hasAttached($this->muscle)->create();

        // Create fake exercise
        $this->equipment = Equipment::factory()->create();

        // Create fake period
        $this->period = Period::factory()->create();

        // Create fake type
        $this->type = Type::factory()->create();

        // Create fake session
        $this->session = Session::factory()->for($this->period)->for($this->type)->create();

        // Create fake set
        $this->set = Set::factory()->for($this->exercise)->for($this->equipment)->for($this->session)->create();

        // Update model
        $this->result = Set::with('exercise')->with('equipment')->with('session')->find($this->set->id);
    }

    public function test_the_exercise_relation_works()
    {
        $this->assertTrue($this->result->exercise->id === $this->exercise->id);
    }

    public function test_the_equipment_relation_works()
    {
        $this->assertTrue($this->result->equipment->id === $this->equipment->id);
    }

    public function test_the_session_relation_works()
    {
        $this->assertTrue($this->result->session->id === $this->session->id);
    }
}
