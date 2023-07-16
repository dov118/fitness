<?php

namespace Tests\Feature;

use App\Models\Group;
use App\Models\Muscle;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class MuscleControllerShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_admin_muscle_show_redirect_dashboard_when_not_user_connected(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();

        $response = $this->get(route('admin.muscle.show', $muscle));

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    public function test_the_admin_muscle_show_returns_a_successful_response_when_user_connected(): void
    {
        $user = User::factory()->create();
        Auth::login($user);

        Group::factory()->create();
        $muscle = Muscle::factory()->create();

        $response = $this->get(route('admin.muscle.show', $muscle));

        $response->assertStatus(200);
    }
}
