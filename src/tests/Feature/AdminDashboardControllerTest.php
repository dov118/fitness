<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_admin_dashboard_index_returns_a_successful_response(): void
    {
        $response = $this->get(route('admin.index'));

        $response->assertStatus(200);
    }
}
