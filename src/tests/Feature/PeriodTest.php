<?php

namespace Tests\Feature;

use App\Models\Period;
use App\Models\Session;
use App\Models\Type;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PeriodTest extends TestCase
{
    use RefreshDatabase;

    public function test_relations_works()
    {
        // Create fake type
        $type = Type::factory()->create();

        // Create fake period
        $period = Period::factory()->create();

        // Create fake sessions
        $sessions = Session::factory(10)->for($type)->for($period)->create();

        // Update models
        $result = Period::with('sessions')->find($period->id);

        foreach ($result->sessions as $item) {
            $this->assertTrue(in_array($item->id, $sessions->pluck('id')->toArray()));
        }
    }
}
