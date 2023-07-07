<?php

namespace Tests\Feature;

use App\Models\Group;
use App\Models\Muscle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GroupTest extends TestCase
{
    use RefreshDatabase;

    public function test_relations_works()
    {
        // Create fake group
        $group = Group::factory()->create();

        // Create fake muscles
        $muscles = Muscle::factory(10)->for($group)->create();

        // Update models
        $result = Group::with('muscles')->find($group->id);

        foreach ($result->muscles as $item) {
            $this->assertTrue(in_array($item->id, $muscles->pluck('id')->toArray()));
        }
    }
}
