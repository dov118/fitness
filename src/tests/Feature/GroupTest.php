<?php

namespace Tests\Feature;

use App\Models\Group;
use App\Models\Muscle;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GroupTest extends TestCase
{
    use RefreshDatabase;

    protected Model $group;
    protected Collection $muscles;
    protected Model $result;

    public function setUp(): void
    {
        parent::setUp();

        // Create fake group
        $this->group = Group::factory()->create();

        // Create fake muscles
        $this->muscles = Muscle::factory(10)->for($this->group)->create();

        // Update model
        $this->result = Group::with('muscles')->find($this->group->id);
    }

    public function test_the_muscles_relation_works()
    {
        foreach ($this->result->muscles as $item) {
            $this->assertTrue(in_array($item->id, $this->muscles->pluck('id')->toArray()));
        }
    }
}
