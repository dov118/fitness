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

    public function setUp(): void
    {
        parent::setUp();

        // Create fake group
        $this->group = Group::factory()->create();

        // Create fake exercises
        $this->exercises = Exercise::factory(10)->create();

        // Create fake muscle
        $this->muscle = Muscle::factory()->for($this->group)->hasAttached($this->exercises)->create();

        $this->intensity = fake()->randomFloat(2, 0, 1);
        foreach ($this->exercises as $exercise) {
            $this->muscle->setIntensity($exercise->id, $this->intensity);
        }

        // Update model
        $this->result = Muscle::with('exercises')->with('group')->find($this->muscle->id);
    }

    public function test_the_group_relation_works()
    {
        $this->assertTrue($this->result->group->id === $this->group->id);
    }

    public function test_the_exercises_relation_works()
    {
        foreach ($this->result->exercises as $item) {
            $this->assertTrue(in_array($item->id, $this->exercises->pluck('id')->toArray()));
        }
    }

    public function test_the_intensity_return_correct_value()
    {
        foreach ($this->exercises as $exercise) {
            $this->assertTrue($this->result->intensities[$exercise->id] === $this->intensity);
        }
    }
}
