<?php

namespace Tests\Feature;

use App\Models\Exercise;
use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class MuscleControllerCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_admin_muscle_create_redirect_dashboard_when_not_user_connected(): void
    {
        $response = $this->get(route('admin.muscle.create'));

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    public function test_the_admin_muscle_create_returns_a_successful_response_when_user_connected(): void
    {
        $user = User::factory()->create();
        Auth::login($user);

        Group::factory(10)->create();
        Exercise::factory(10)->create();

        $response = $this->get(route('admin.muscle.create'));

        $response->assertStatus(200);
    }
}
