<?php

namespace Tests\Feature;

use App\Models\Equipment;
use App\Models\Exercise;
use App\Models\Period;
use App\Models\Session;
use App\Models\Set;
use App\Models\Type;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EquipmentTest extends TestCase
{
    use RefreshDatabase;

    protected Model $equipment;
    protected Collection $sets;
    protected Model $period;
    protected Model $type;
    protected Model $session;
    protected Model $result;

    public function setUp(): void
    {
        parent::setUp();

        // Create fake exercise
        Exercise::factory()->create();

        // Create fake equipment
        $this->equipment = Equipment::factory()->create();

        // Create fake period
        $this->period = Period::factory()->create();

        // Create fake type
        $this->type = Type::factory()->create();

        // Create fake session
        $this->session = Session::factory()->for($this->period)->for($this->type)->create();

        // Create fake sets
        $this->sets = Set::factory(10)->for($this->equipment)->for($this->session)->create();

        // Update model
        $this->result = Equipment::with('sets')->find($this->equipment->id);
    }

    public function test_the_sets_relation_works()
    {
        foreach ($this->result->sets as $item) {
            $this->assertTrue(in_array($item->id, $this->sets->pluck('id' )->toArray()));
        }
    }
}
