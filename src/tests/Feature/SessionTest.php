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
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SessionTest extends TestCase
{
    use RefreshDatabase;

    protected Model $group;
    protected Model $muscle;
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

        // Create fake sets
        $this->sets = Set::factory(10)->for($this->exercise)->for($this->equipment)->for($this->session)->create();

        // Update model
        $this->result = Session::with('period')->with('type')->with('sets')->find($this->session->id)->first();
    }

    public function test_the_type_relation_works()
    {
        $this->assertTrue($this->type->id === $this->result->type->id);
    }

    public function test_the_period_relation_works()
    {
        $this->assertTrue($this->period->id === $this->result->period->id);
    }

    public function test_the_sets_relation_works()
    {
        foreach ($this->result->sets as $item) {
            $this->assertTrue(in_array($item->id, $this->sets->pluck('id')->toArray()));
        }
    }
}
