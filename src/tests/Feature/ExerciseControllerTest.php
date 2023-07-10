<?php

namespace Tests\Feature;

use App\Models\Exercise;
use App\Models\Group;
use App\Models\Muscle;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ExerciseControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        Auth::login($user);
    }

    public function test_the_admin_exercise_index_returns_a_successful_response(): void
    {
        $response = $this->get(route('admin.exercise.index'));

        $response->assertStatus(200);
    }

    public function test_the_admin_exercise_index_displayed_all_information(): void
    {
        Group::factory()->create();

        $muscles = Muscle::factory(3)->create();

        $exercise = Exercise::factory()->hasAttached($muscles)->create();

        $response = $this->get(route('admin.exercise.index'));

        foreach ($muscles as $muscle) {
            $response->assertSee($muscle->name);
        }
        $response->assertSee($exercise->name);
    }

    public function test_the_admin_exercise_create_page_returns_a_successful_response(): void
    {
        $response = $this->get(route('admin.exercise.create'));

        $response->assertStatus(200);
    }

    public function test_the_admin_exercise_create_action_returns_a_successful_response(): void
    {
        $exercise_raw = Exercise::factory()->definition();

        $response = $this->postJson(route('admin.exercise.store'), $exercise_raw);

        $this->assertDatabaseHas(app(Exercise::class)->getTable(), $exercise_raw);

        $response
            ->assertSessionDoesntHaveErrors()
            ->assertRedirect(route('admin.exercise.index'))
            ->assertStatus(302)
            ->assertSessionHas('notification_type', 'success')
            ->assertSessionHas('notification_message');
    }

    public function test_the_admin_exercise_create_action_returns_an_error_if_new_name_already_used(): void
    {
        $exercise_name = fake()->text(64);

        $exercise_raw = Exercise::factory()->definition();
        Exercise::factory()->create($exercise_raw);
        $exercise_raw['name'] = $exercise_name;

        $response = $this->postJson(route('admin.exercise.store'), $exercise_raw);

        $response->assertSessionMissing('name');
    }

    public function test_the_admin_exercise_edit_page_returns_a_successful_response(): void
    {
        $exercise = Exercise::factory()->create();

        $response = $this->get(route('admin.exercise.edit', $exercise));

        $response->assertStatus(200);
    }

    public function test_the_admin_exercise_update_action_returns_a_successful_response(): void
    {
        $old_exercise_raw = Exercise::factory()->definition();

        $exercise = Exercise::factory()->create($old_exercise_raw);

        $new_exercise_raw = Exercise::factory()->definition();

        $response = $this->putJson(route('admin.exercise.update', $exercise), $new_exercise_raw);

        $this->assertDatabaseHas(app(Exercise::class)->getTable(), $new_exercise_raw);

        $response
            ->assertSessionDoesntHaveErrors()
            ->assertRedirect(route('admin.exercise.index'))
            ->assertStatus(302)
            ->assertSessionHas('notification_type', 'success')
            ->assertSessionHas('notification_message');
    }

    public function test_the_admin_exercise_update_action_returns_an_error_if_new_name_already_used(): void
    {
        $exercise_name = fake()->text(64);

        $old_exercise_raw = Exercise::factory()->definition();
        $old_exercise_raw['name'] = $exercise_name;

        $exercise = Exercise::factory()->create($old_exercise_raw);

        $new_exercise_raw = Exercise::factory()->definition();
        $new_exercise_raw['name'] = $exercise_name;

        $response = $this->putJson(route('admin.exercise.update', $exercise), $new_exercise_raw);

        $response->assertSessionMissing('name');
    }

    public function test_the_admin_exercise_show_returns_a_successful_response(): void
    {
        $exercise = Exercise::factory()->create();

        $response = $this->get(route('admin.exercise.show', $exercise));

        $response->assertStatus(200);
    }

    public function test_the_admin_exercise_show_displayed_all_information(): void
    {
        $exercise = Exercise::factory()->create();

        $response = $this->get(route('admin.exercise.show', $exercise));

        $response->assertSee($exercise->name);
    }

    // TODO test attached
}
