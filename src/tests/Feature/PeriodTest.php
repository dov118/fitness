<?php

namespace Tests\Feature;

use App\Models\Period;
use App\Models\Session;
use App\Models\Type;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PeriodTest extends TestCase
{
    use RefreshDatabase;

    protected Model $type;
    protected Model $period;
    protected Collection $sessions;
    protected Model $result;

    public function setUp(): void
    {
        parent::setUp();

        // Create fake type
        $this->type = Type::factory()->create();

        // Create fake period
        $this->period = Period::factory()->create();

        // Create fake sessions
        $this->sessions = Session::factory(10)->for($this->type)->for($this->period)->create();

        // Update model
        $this->result = Period::with('sessions')->find($this->period->id);
    }

    public function test_the_sessions_relation_works()
    {
        foreach ($this->result->sessions as $item) {
            $this->assertTrue(in_array($item->id, $this->sessions->pluck('id')->toArray()));
        }
    }
}
