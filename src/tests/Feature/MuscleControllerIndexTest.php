<?php

namespace Tests\Feature;

use App\Models\Group;
use App\Models\Muscle;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class MuscleControllerIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_admin_muscle_index_redirect_dashboard_when_not_user_connected(): void
    {
        $response = $this->get(route('admin.muscle.index'));

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    public function test_the_admin_muscle_index_returns_a_successful_response_when_user_connected(): void
    {
        $user = User::factory()->create();
        Auth::login($user);

        Group::factory()->create();
        Muscle::factory()->create();

        $response = $this->get(route('admin.muscle.index'));

        $response->assertStatus(200);
    }
}
