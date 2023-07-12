<?php

namespace Tests\Feature;

use App\Models\Exercise;
use App\Models\Group;
use App\Models\Muscle;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class MuscleControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        Auth::login($user);
    }

    public function test_the_admin_muscle_index_returns_a_successful_response(): void
    {
        $response = $this->get(route('admin.muscle.index'));

        $response->assertStatus(200);
    }

    public function test_the_admin_muscle_index_displayed_all_information(): void
    {
        $exercise = Exercise::factory()->create();

        $group = Group::factory()->create();

        $muscle = Muscle::factory()->for($group)->hasAttached($exercise, [
            'intensity' => 1.0,
        ])->create();

        $muscle = $muscle->refresh();
        $exercise = $exercise->refresh();

        $response = $this->get(route('admin.muscle.index'));

        $response->assertSee($muscle->name);
        $response->assertSee($group->name);
        $response->assertSee($exercise->name);
    }

    public function test_the_admin_muscle_index_not_displaying_zero_intensity_exercise_name(): void
    {
        $exercise = Exercise::factory()->create();

        $group = Group::factory()->create();

        $muscle = Muscle::factory()->for($group)->hasAttached($exercise, [
            'intensity' => 0,
        ])->create();

        $muscle = $muscle->refresh();
        $exercise = $exercise->refresh();

        $response = $this->get(route('admin.muscle.index'));

        $response->assertSee($muscle->name);
        $response->assertSee($group->name);
        $response->assertDontSee($exercise->name);
    }

    public function test_the_admin_muscle_create_page_returns_a_successful_response(): void
    {
        $response = $this->get(route('admin.muscle.create'));

        $response->assertStatus(200);
    }

    public function test_the_admin_group_create_action_returns_a_successful_response(): void
    {
        $muscle_name = fake()->text(64);

        $group = Group::factory()->create();

        $response = $this->postJson(route('admin.muscle.store'), [
            'name' => $muscle_name,
            'group_id' => $group->id,
        ]);

        $this->assertDatabaseHas(app(Muscle::class)->getTable(), [
            'name' => $muscle_name,
            'group_id' => $group->id,
        ]);

        $muscle = Muscle::where('name', $muscle_name)->with('group')->get()->first();

        $this->assertTrue($muscle->group->id === $group->id);
        foreach (Exercise::all() as $exercise) {
            $this->assertTrue($muscle->exercises->contains($exercise->id));
        }

        $response
            ->assertSessionDoesntHaveErrors()
            ->assertRedirect(route('admin.muscle.index'))
            ->assertStatus(302)
            ->assertSessionHas('notification_type', 'success')
            ->assertSessionHas('notification_message');
    }

    public function test_the_admin_muscle_create_action_returns_an_error_if_new_name_already_used(): void
    {
        $group = Group::factory()->create();
        $muscle = Muscle::factory()->create();

        $response = $this->putJson(route('admin.muscle.store'), [
            'name' => $muscle->name,
            'group_id' => $group->id,
        ]);

        $response->assertSessionMissing('name');
    }

    public function test_the_admin_group_create_action_returns_a_successful_response_when_group_doesnt_exist(): void
    {
        $group_id = 4;
        $name = fake()->text(64);

        $this->assertDatabaseMissing(app(Group::class)->getTable(), [
            'id' => $group_id,
        ]);

        $response = $this->postJson(route('admin.muscle.store'), [
            'name' => $name,
            'group_id' => $group_id,
        ]);

        $this->assertDatabaseMissing(app(Muscle::class)->getTable(), [
            'name' => $name,
            'group_id' => $group_id,
        ]);

        $response
            ->assertSessionMissing('group_id')
            ->assertStatus(422);
    }

    public function test_the_admin_muscle_edit_page_returns_a_successful_response(): void
    {
        Group::factory()->create();

        $muscle = Muscle::factory()->create();

        $response = $this->get(route('admin.muscle.edit', $muscle));

        $response->assertStatus(200);
    }

    public function test_the_admin_muscle_edit_page_displayed_all_information(): void
    {
        $exercise = Exercise::factory()->create();

        $group = Group::factory()->create();

        $muscle = Muscle::factory()->hasAttached($exercise)->for($group)->create();

        $response = $this->get(route('admin.muscle.edit', $muscle));

        $response->assertSee($exercise->name);
        $response->assertSee($group->name);
        $response->assertSee($muscle->name);
    }

    public function test_the_admin_muscle_update_action_returns_a_successful_response(): void
    {
        $group = Group::factory()->create();

        $muscle_name = fake()->text(64);
        $muscle = Muscle::factory()->create(['name' => $muscle_name, 'group_id' => $group->id]);

        $this->assertTrue(Muscle::find($muscle->id)->name === $muscle_name);

        $muscle_name = fake()->text(64);

        $response = $this->putJson(route('admin.muscle.update', $muscle), [
            'name' => $muscle_name,
            'group_id' => $group->id,
        ]);

        $this->assertTrue(Muscle::find($muscle->id)->name === $muscle_name);

        $response
            ->assertSessionDoesntHaveErrors()
            ->assertRedirect(route('admin.muscle.index'))
            ->assertStatus(302)
            ->assertSessionHas('notification_type', 'success')
            ->assertSessionHas('notification_message');
    }

    public function test_the_admin_muscle_update_action_returns_an_error_if_new_name_already_used(): void
    {
        $group = Group::factory()->create();

        $other_muscle_name = fake()->text(64);
        Muscle::factory()->create(['name' => $other_muscle_name, 'group_id' => $group->id]);

        $muscle_name = fake()->text(64);
        $muscle = Muscle::factory()->create(['name' => $muscle_name, 'group_id' => $group->id]);

        $this->assertTrue(Muscle::find($muscle->id)->name === $muscle_name);

        $response = $this->putJson(route('admin.muscle.update', $muscle), [
            'name' => $other_muscle_name,
            'group_id' => $group->id,
        ]);

        $response
            ->assertSessionMissing('name')
            ->assertStatus(422);
    }

    public function test_the_admin_muscle_update_action_returns_a_successful_response_when_group_exist(): void
    {
        $group = Group::factory()->create();
        $new_group = Group::factory()->create();
        $muscle = Muscle::factory()->for($group)->create();

        $muscle_name = fake()->text(64);

        $group = $group->refresh();
        $new_group = $new_group->refresh();
        $muscle = $muscle->refresh();

        $this->assertTrue($muscle->name !== $muscle_name);
        $this->assertTrue($muscle->group->is($group));

        $response = $this->putJson(route('admin.muscle.update', $muscle), [
            'name' => $muscle_name,
            'group_id' => $new_group->id,
        ]);

        $new_group = $new_group->refresh();
        $muscle = $muscle->refresh();

        $this->assertTrue($muscle->name === $muscle_name);
        $this->assertTrue($muscle->group->is($new_group));

        $response
            ->assertSessionDoesntHaveErrors()
            ->assertRedirect(route('admin.muscle.index'))
            ->assertStatus(302)
            ->assertSessionHas('notification_type', 'success')
            ->assertSessionHas('notification_message');
    }

    public function test_the_admin_muscle_update_action_returns_a_successful_response_when_group_doesnt_exist(): void
    {
        $new_group_id = 4;
        $group = Group::factory()->create();
        $muscle = Muscle::factory()->for($group)->create();

        $group = $group->refresh();
        $muscle = $muscle->refresh();

        $this->assertTrue($muscle->group->is($group));
        $this->assertDatabaseMissing(app(Group::class)->getTable(), [
            'id' => $new_group_id,
        ]);

        $response = $this->putJson(route('admin.muscle.update', $muscle), [
            'name' => $group->name,
            'group_id' => $new_group_id,
        ]);

        $group = $group->refresh();
        $muscle = $muscle->refresh();

        $this->assertTrue($muscle->group->is($group));

        $response
            ->assertSessionMissing('group_id')
            ->assertStatus(422);
    }

    public function test_the_admin_muscle_update_action_returns_a_successful_response_when_update_all_exercise(): void
    {
        Exercise::factory()->create(['id' => 1]);
        Exercise::factory()->create(['id' => 2]);
        Exercise::factory()->create(['id' => 3]);
        Exercise::factory()->create(['id' => 4]);
        Exercise::factory()->create(['id' => 5]);
        $exercises = Exercise::whereIn('id', [1, 2, 3, 4, 5])->get()->all();

        $group = Group::factory()->create();

        $muscle = Muscle::factory()->hasAttached($exercises, [
            'intensity' => 1.0,
        ])->for($group)->create();

        $params = [];
        $params['name'] = $muscle->name;
        $params['group_id'] = $group->id;

        $muscle = $muscle->refresh();
        $exercises = Exercise::whereIn('id', [1, 2, 3, 4, 5])->get()->all();

        foreach ($exercises as $exercise) {
            $this->assertTrue($exercise->muscles->find($muscle->id)->pivot->intensity === 1.0);
            $params['option-' . $exercise->id] = 0.5;
        }

        $response = $this->putJson(route('admin.muscle.update', $muscle), $params);

        $muscle = $muscle->refresh();
        $exercises = Exercise::whereIn('id', [1, 2, 3, 4, 5])->get()->all();

        foreach ($exercises as $exercise) {
            $this->assertTrue($exercise->muscles->find($muscle->id)->pivot->intensity === 0.5);
        }

        $response
            ->assertSessionDoesntHaveErrors()
            ->assertRedirect(route('admin.muscle.index'))
            ->assertStatus(302)
            ->assertSessionHas('notification_type', 'success')
            ->assertSessionHas('notification_message');
    }

    public function test_the_admin_muscle_update_action_returns_a_successful_response_when_add_exercise(): void
    {
        $newExercise = Exercise::factory()->create(['id' => 6]);

        Exercise::factory()->create(['id' => 1]);
        Exercise::factory()->create(['id' => 2]);
        Exercise::factory()->create(['id' => 3]);
        Exercise::factory()->create(['id' => 4]);
        Exercise::factory()->create(['id' => 5]);
        $exercises = Exercise::whereIn('id', [1, 2, 3, 4, 5])->get()->all();

        $group = Group::factory()->create();

        $muscle = Muscle::factory()
            ->hasAttached($exercises, ['intensity' => 1.0,])
            ->hasAttached($newExercise, ['intensity' => 0.0])
            ->for($group)->create();

        $params = [];
        $params['name'] = $muscle->name;
        $params['group_id'] = $group->id;

        $muscle = $muscle->refresh();
        $newExercise = $newExercise->refresh();
        $exercises = Exercise::whereIn('id', [1, 2, 3, 4, 5])->get()->all();

        foreach ($exercises as $exercise) {
            $this->assertTrue($exercise->muscles->find($muscle->id)->pivot->intensity === 1.0);
            $params['option-' . $exercise->id] = 0.5;
        }
        $params['option-' . $newExercise->id] = 0.25;
        $this->assertTrue($newExercise->muscles->find($muscle->id)->pivot->intensity === 0.0);

        $response = $this->putJson(route('admin.muscle.update', $muscle), $params);

        $muscle = $muscle->refresh();
        $newExercise = $newExercise->refresh();
        $exercises = Exercise::whereIn('id', [1, 2, 3, 4, 5])->get()->all();

        foreach ($exercises as $exercise) {
            $this->assertTrue($exercise->muscles->find($muscle->id)->pivot->intensity === 0.5);
        }
        $this->assertTrue($newExercise->muscles->find($muscle->id)->pivot->intensity === 0.25);

        $response
            ->assertSessionDoesntHaveErrors()
            ->assertRedirect(route('admin.muscle.index'))
            ->assertStatus(302)
            ->assertSessionHas('notification_type', 'success')
            ->assertSessionHas('notification_message');
    }

    public function test_the_admin_muscle_update_action_returns_a_successful_response_when_remove_exercise(): void
    {
        $removeExercise = Exercise::factory()->create(['id' => 1]);
        Exercise::factory()->create(['id' => 2]);
        Exercise::factory()->create(['id' => 3]);
        Exercise::factory()->create(['id' => 4]);
        Exercise::factory()->create(['id' => 5]);
        $exercises = Exercise::whereIn('id', [2, 3, 4, 5])->get()->all();

        $group = Group::factory()->create();

        $muscle = Muscle::factory()
            ->hasAttached($exercises, ['intensity' => 1.0,])
            ->hasAttached($removeExercise, ['intensity' => 1.0,])
            ->for($group)->create();

        $params = [];
        $params['name'] = $muscle->name;
        $params['group_id'] = $group->id;

        $muscle = $muscle->refresh();
        $removeExercise = $removeExercise->refresh();
        $exercises = Exercise::whereIn('id', [2, 3, 4, 5])->get()->all();

        foreach ($exercises as $exercise) {
            $this->assertTrue($exercise->muscles->find($muscle->id)->pivot->intensity === 1.0);
            $params['option-' . $exercise->id] = 0.5;
        }
        $this->assertTrue($removeExercise->muscles->find($muscle->id)->pivot->intensity === 1.0);
        $params['option-' . $removeExercise->id] = 0.0;

        $response = $this->putJson(route('admin.muscle.update', $muscle), $params);

        $muscle = $muscle->refresh();
        $removeExercise = $removeExercise->refresh();
        $exercises = Exercise::whereIn('id', [2, 3, 4, 5])->get()->all();

        foreach ($exercises as $exercise) {
            $this->assertTrue($exercise->muscles->find($muscle->id)->pivot->intensity === 0.5);
        }
        $this->assertTrue($removeExercise->muscles->find($muscle->id)->pivot->intensity === 0.0);

        $response
            ->assertSessionDoesntHaveErrors()
            ->assertRedirect(route('admin.muscle.index'))
            ->assertStatus(302)
            ->assertSessionHas('notification_type', 'success')
            ->assertSessionHas('notification_message');
    }

    public function test_the_admin_muscle_show_returns_a_successful_response(): void
    {
        Group::factory()->create();

        $muscle = Muscle::factory()->create();

        $response = $this->get(route('admin.muscle.show', $muscle));

        $response->assertStatus(200);
    }

    public function test_the_admin_muscle_show_displayed_all_information(): void
    {
        $exercise = Exercise::factory()->create();

        $group = Group::factory()->create();

        $muscle = Muscle::factory()->for($group)->hasAttached($exercise, [
            'intensity' => 1.0,
        ])->create();

        $response = $this->get(route('admin.muscle.show', $muscle));

        $response->assertSee($muscle->name);
        $response->assertSee($group->name);
        $response->assertSee($exercise->name);
    }

    public function test_the_admin_muscle_show_not_displaying_zero_intensity_exercise_name(): void
    {
        $exercise = Exercise::factory()->create();

        $group = Group::factory()->create();

        $muscle = Muscle::factory()->for($group)->hasAttached($exercise, [
            'intensity' => 0,
        ])->create();

        $response = $this->get(route('admin.muscle.show', $muscle));

        $response->assertSee($muscle->name);
        $response->assertSee($group->name);
        $response->assertDontSee($exercise->name);
    }

    public function test_the_admin_muscle_delete_action_with_no_exercises_attached_returns_a_successful_response(): void
    {
        $group = Group::factory()->create();

        $muscle = Muscle::factory()->for($group)->create();

        $response = $this->deleteJson(route('admin.muscle.destroy', $muscle));

        $this->assertDatabaseMissing(app(Muscle::class)->getTable(), [
            'id' => $muscle->id,
        ]);

        $response
            ->assertSessionDoesntHaveErrors()
            ->assertRedirect(route('admin.muscle.index'))
            ->assertStatus(302)
            ->assertSessionHas('notification_type', 'success')
            ->assertSessionHas('notification_message');
    }

    public function test_the_admin_muscle_delete_action_with_exercises_attached_returns_a_successful_response(): void
    {
        $group = Group::factory()->create();

        $muscle = Muscle::factory()->for($group)->create();

        Exercise::factory(10)->hasAttached($muscle)->create();

        $response = $this->deleteJson(route('admin.muscle.destroy', $muscle));

        $this->assertDatabaseHas(app(Group::class)->getTable(), [
            'id' => $muscle->id,
        ]);

        $response
            ->assertSessionDoesntHaveErrors()
            ->assertRedirect(route('admin.muscle.index'))
            ->assertStatus(302)
            ->assertSessionHas('notification_type', 'error')
            ->assertSessionHas('notification_message');
    }
}
