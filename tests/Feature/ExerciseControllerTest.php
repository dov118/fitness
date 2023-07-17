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
        Muscle::factory()->create();

        $exerciseRaw = Exercise::factory()->definition();

        $response = $this->postJson(route('admin.exercise.store'), $exerciseRaw);

        $exercise = Exercise::where('name', $exerciseRaw['name'])->with('muscles')->get()->first();

        $this->assertDatabaseHas(app(Exercise::class)->getTable(), $exerciseRaw);

        $this->assertTrue(!Muscle::all()->isEmpty());
        foreach (Muscle::all() as $muscle) {
            $this->assertTrue($exercise->muscles->contains($muscle->id));
        }

        $response
            ->assertSessionDoesntHaveErrors()
            ->assertRedirect(route('admin.exercise.index'))
            ->assertStatus(302)
            ->assertSessionHas('notification_type', 'success')
            ->assertSessionHas('notification_message');
    }

    public function test_the_admin_exercise_create_action_returns_an_error_if_new_name_already_used(): void
    {
        $exerciseName = fake()->text(64);

        $exerciseRaw = Exercise::factory()->definition();
        Exercise::factory()->create($exerciseRaw);
        $exerciseRaw['name'] = $exerciseName;

        $response = $this->postJson(route('admin.exercise.store'), $exerciseRaw);

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
        $oldExerciseRaw = Exercise::factory()->definition();

        $exercise = Exercise::factory()->create($oldExerciseRaw);

        $newExerciseRaw = Exercise::factory()->definition();

        $response = $this->putJson(route('admin.exercise.update', $exercise), $newExerciseRaw);

        $this->assertDatabaseHas(app(Exercise::class)->getTable(), $newExerciseRaw);

        $response
            ->assertSessionDoesntHaveErrors()
            ->assertRedirect(route('admin.exercise.index'))
            ->assertStatus(302)
            ->assertSessionHas('notification_type', 'success')
            ->assertSessionHas('notification_message');
    }

    public function test_the_admin_exercise_update_action_returns_an_error_if_new_name_already_used(): void
    {
        $exerciseName = fake()->text(64);

        $oldExerciseRaw = Exercise::factory()->definition();
        $oldExerciseRaw['name'] = $exerciseName;

        $exercise = Exercise::factory()->create($oldExerciseRaw);

        $newExerciseRaw = Exercise::factory()->definition();
        $newExerciseRaw['name'] = $exerciseName;

        $response = $this->putJson(route('admin.exercise.update', $exercise), $newExerciseRaw);

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
}
