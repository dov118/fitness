<?php

namespace Tests\Feature;

use App\Models\Equipment;
use App\Models\Exercise;
use App\Models\Set;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EquipmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_relations_works()
    {
        $this->expectsDatabaseQueryCount(34*5);

        for ($i = 0; $i < 5; $i++) {
            // Create fake exercise
            Exercise::factory()->create();

            // Create fake equipment
            $equipment = Equipment::factory()->create();

            // Create fake sets
            $sets = Set::factory(10)->for($equipment)->create();

            // Update models
            $result = Equipment::with('sets')->find($equipment->id);

            foreach ($result->sets as $item) {
                $this->assertTrue(in_array($item->id, $sets->pluck('id' )->toArray()));
            }
        }
    }
}
