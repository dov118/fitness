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

    public function test_the_admin_muscle_index_displayed_groups_and_muscles_name(): void
    {
        $group = Group::factory()->create();

        $muscle = Muscle::factory()->for($group)->create();

        $response = $this->get(route('admin.muscle.index'));

        $response->assertSee($muscle->name);
        $response->assertSee($group->name);
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

    public function test_the_admin_muscle_show_returns_a_successful_response(): void
    {
        Group::factory()->create();

        $muscle = Muscle::factory()->create();

        $response = $this->get(route('admin.muscle.show', $muscle));

        $response->assertStatus(200);
    }

    public function test_the_admin_muscle_show_displayed_groups_and_muscles_name(): void
    {
        $group = Group::factory()->create();

        $muscle = Muscle::factory()->for($group)->create();

        $response = $this->get(route('admin.muscle.show', $muscle));

        $response->assertSee($muscle->name);
        $response->assertSee($group->name);
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
