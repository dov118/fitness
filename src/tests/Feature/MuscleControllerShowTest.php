<?php

namespace Tests\Feature;

use App\Models\Exercise;
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
        Exercise::factory()->hasAttached($muscle, ['intensity' => 1.0])->create();
        Exercise::factory()->hasAttached($muscle, ['intensity' => 0.5])->create();

        $response = $this->get(route('admin.muscle.show', $muscle));

        $response->assertStatus(200);
    }

    public function test_the_admin_muscle_show_returns_a_successful_response_with_no_group_and_exercise(): void
    {
        $user = User::factory()->create();
        Auth::login($user);

        $muscle = Muscle::factory()->create();

        $response = $this->get(route('admin.muscle.show', $muscle));

        $response->assertStatus(200);
    }
}
