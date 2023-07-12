<?php

namespace Tests\Feature;

use App\Models\Group;
use App\Models\Muscle;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class GroupControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        Auth::login($user);
    }

    public function test_the_admin_group_index_returns_a_successful_response(): void
    {
        $response = $this->get(route('admin.group.index'));

        $response->assertStatus(200);
    }

    public function test_the_admin_group_index_displayed_groups_and_muscles_name(): void
    {
        $groupName = fake()->text(64);

        $group = Group::factory()->create(['name' => $groupName]);

        $muscles = Muscle::factory(4)->for($group)->create();

        $response = $this->get(route('admin.group.index'));

        foreach ($muscles->pluck('name')->toArray() as $name) {
            $response->assertSee($name);
        }

        $response->assertSee($groupName);
    }

    public function test_the_admin_group_create_page_returns_a_successful_response(): void
    {
        $response = $this->get(route('admin.group.create'));

        $response->assertStatus(200);
    }

    public function test_the_admin_group_create_action_returns_a_successful_response(): void
    {
        $groupName = fake()->text(64);

        $response = $this->postJson(route('admin.group.store'), [
            'name' => $groupName,
        ]);

        $this->assertDatabaseHas(app(Group::class)->getTable(), [
            'name' => $groupName,
        ]);

        $response
            ->assertSessionDoesntHaveErrors()
            ->assertRedirect(route('admin.group.index'))
            ->assertStatus(302)
            ->assertSessionHas('notification_type', 'success')
            ->assertSessionHas('notification_message');
    }

    public function test_the_admin_group_create_action_returns_an_error_if_new_name_already_used(): void
    {
        $group = Group::factory()->create();

        $response = $this->putJson(route('admin.group.store'), [
            'name' => $group->name,
        ]);

        $response->assertSessionMissing('name');
    }

    public function test_the_admin_group_edit_page_returns_a_successful_response(): void
    {
        $group = Group::factory()->create();

        $response = $this->get(route('admin.group.edit', $group));

        $response->assertStatus(200);
    }

    public function test_the_admin_group_update_action_returns_a_successful_response(): void
    {
        $groupName = fake()->text(64);
        $group = Group::factory()->create(['name' => $groupName]);

        $this->assertTrue(Group::find($group->id)->name === $groupName);

        $groupName = fake()->text(64);

        $response = $this->putJson(route('admin.group.update', $group), [
            'name' => $groupName,
        ]);

        $this->assertTrue(Group::find($group->id)->name === $groupName);

        $response
            ->assertSessionDoesntHaveErrors()
            ->assertRedirect(route('admin.group.index'))
            ->assertStatus(302)
            ->assertSessionHas('notification_type', 'success')
            ->assertSessionHas('notification_message');
    }

    public function test_the_admin_group_update_action_returns_an_error_if_new_name_already_used(): void
    {
        $otherGroupName = fake()->text(64);
        Group::factory()->create(['name' => $otherGroupName]);

        $groupName = fake()->text(64);
        $group = Group::factory()->create(['name' => $groupName]);

        $this->assertTrue(Group::find($group->id)->name === $groupName);

        $response = $this->putJson(route('admin.group.update', $group), [
            'name' => $otherGroupName,
        ]);

        $response
            ->assertSessionMissing('name')
            ->assertStatus(422);
    }

    public function test_the_admin_group_update_action_returns_a_successful_response_with_full_muscle_changes(): void
    {
        $groupName = fake()->text(64);
        $group = Group::factory()->create(['name' => $groupName]);

        Muscle::factory()->for($group)->create(['id' => 1]);
        Muscle::factory()->for($group)->create(['id' => 2]);
        Muscle::factory()->for($group)->create(['id' => 3]);

        Muscle::factory()->create(['id' => 4, 'group_id' => null]);
        Muscle::factory()->create(['id' => 5, 'group_id' => null]);
        Muscle::factory()->create(['id' => 6, 'group_id' => null]);

        $oldMuscles = Muscle::whereIn('id', [1, 2, 3])->get();
        $newMuscles = Muscle::whereIn('id', [4, 5, 6])->get();

        $params = [];
        $params['name'] = $groupName;

        $group = $group->refresh();
        $oldMuscles = $oldMuscles->map(fn ($muscle) => $muscle->refresh());
        $newMuscles = $newMuscles->map(fn ($muscle) => $muscle->refresh());

        foreach ($oldMuscles as $muscle) {
            $this->assertTrue($group->muscles->contains($muscle));
        }

        foreach ($newMuscles as $muscle) {
            $this->assertTrue($group->muscles->doesntContain($muscle));
            $params['muscle_' . $muscle->id] = 'on';
        }

        $response = $this->putJson(route('admin.group.update', $group), $params);

        $group = $group->refresh();
        $oldMuscles = $oldMuscles->map(fn ($muscle) => $muscle->refresh());
        $newMuscles = $newMuscles->map(fn ($muscle) => $muscle->refresh());

        foreach ($oldMuscles as $muscle) {
            $this->assertTrue($group->muscles->doesntContain($muscle));
        }

        foreach ($newMuscles as $muscle) {
            $this->assertTrue($group->muscles->contains($muscle));
        }

        $response
            ->assertSessionDoesntHaveErrors()
            ->assertRedirect(route('admin.group.index'))
            ->assertStatus(302)
            ->assertSessionHas('notification_type', 'success')
            ->assertSessionHas('notification_message');
    }

    public function test_the_admin_group_update_action_returns_a_successful_response_with_adding_muscle(): void
    {
        $groupName = fake()->text(64);
        $group = Group::factory()->create(['name' => $groupName]);

        Muscle::factory()->for($group)->create(['id' => 1]);
        Muscle::factory()->for($group)->create(['id' => 2]);
        Muscle::factory()->for($group)->create(['id' => 3]);

        Muscle::factory()->create(['id' => 4, 'group_id' => null]);

        $oldMuscles = Muscle::whereIn('id', [1, 2, 3])->get();
        $newMuscles = Muscle::whereIn('id', [4])->get();

        $params = [];
        $params['name'] = $groupName;

        $group = $group->refresh();
        $oldMuscles = $oldMuscles->map(fn ($muscle) => $muscle->refresh());
        $newMuscles = $newMuscles->map(fn ($muscle) => $muscle->refresh());

        foreach ($oldMuscles as $muscle) {
            $this->assertTrue($group->muscles->contains($muscle));
            $params['muscle_' . $muscle->id] = 'on';
        }

        foreach ($newMuscles as $muscle) {
            $this->assertTrue($group->muscles->doesntContain($muscle));
            $params['muscle_' . $muscle->id] = 'on';
        }

        $response = $this->putJson(route('admin.group.update', $group), $params);

        $group = $group->refresh();
        $oldMuscles = $oldMuscles->map(fn ($muscle) => $muscle->refresh());
        $newMuscles = $newMuscles->map(fn ($muscle) => $muscle->refresh());

        foreach ($oldMuscles as $muscle) {
            $this->assertTrue($group->muscles->contains($muscle));
        }

        foreach ($newMuscles as $muscle) {
            $this->assertTrue($group->muscles->contains($muscle));
        }

        $response
            ->assertSessionDoesntHaveErrors()
            ->assertRedirect(route('admin.group.index'))
            ->assertStatus(302)
            ->assertSessionHas('notification_type', 'success')
            ->assertSessionHas('notification_message');
    }

    public function test_the_admin_group_update_action_returns_a_successful_response_with_removing_muscle(): void
    {
        $groupName = fake()->text(64);
        $group = Group::factory()->create(['name' => $groupName]);

        Muscle::factory()->for($group)->create(['id' => 1]);
        Muscle::factory()->for($group)->create(['id' => 2]);
        $removingMuscle = Muscle::factory()->for($group)->create(['id' => 3]);

        $remainingMuscles = Muscle::whereIn('id', [1, 2])->get();

        $params = [];
        $params['name'] = $groupName;

        $group = $group->refresh();
        $removingMuscle = $removingMuscle->refresh();
        $remainingMuscles = $remainingMuscles->map(fn ($muscle) => $muscle->refresh());

        foreach ($remainingMuscles as $muscle) {
            $this->assertTrue($group->muscles->contains($muscle));
            $params['muscle_' . $muscle->id] = 'on';
        }
        $this->assertTrue($group->muscles->contains($removingMuscle));

        $response = $this->putJson(route('admin.group.update', $group), $params);

        $group = $group->refresh();
        $removingMuscle = $removingMuscle->refresh();
        $remainingMuscles = $remainingMuscles->map(fn ($muscle) => $muscle->refresh());

        foreach ($remainingMuscles as $muscle) {
            $this->assertTrue($group->muscles->contains($muscle));
        }
        $this->assertTrue($group->muscles->doesntContain($removingMuscle));

        $response
            ->assertSessionDoesntHaveErrors()
            ->assertRedirect(route('admin.group.index'))
            ->assertStatus(302)
            ->assertSessionHas('notification_type', 'success')
            ->assertSessionHas('notification_message');
    }

    public function test_the_admin_group_update_action_returns_a_successful_response_with_full_adding_muscles(): void
    {
        $groupName = fake()->text(64);
        $group = Group::factory()->create(['name' => $groupName]);

        Muscle::factory()->create(['id' => 1, 'group_id' => null]);
        Muscle::factory()->create(['id' => 2, 'group_id' => null]);
        Muscle::factory()->create(['id' => 3, 'group_id' => null]);
        $muscles = Muscle::whereIn('id', [1, 2, 3])->get();

        $params = [];
        $params['name'] = $groupName;

        $group = $group->refresh();
        $muscles = $muscles->map(fn ($muscle) => $muscle->refresh());

        foreach ($muscles as $muscle) {
            $this->assertTrue($group->muscles->doesntContain($muscle));
            $params['muscle_' . $muscle->id] = 'on';
        }

        $this->assertTrue($group->muscles->isEmpty());

        $response = $this->putJson(route('admin.group.update', $group), $params);

        $group = $group->refresh();
        $muscles = $muscles->map(fn ($muscle) => $muscle->refresh());

        $this->assertTrue(!$group->muscles->isEmpty());

        foreach ($muscles as $muscle) {
            $this->assertTrue($group->muscles->contains($muscle));
        }

        $response
            ->assertSessionDoesntHaveErrors()
            ->assertRedirect(route('admin.group.index'))
            ->assertStatus(302)
            ->assertSessionHas('notification_type', 'success')
            ->assertSessionHas('notification_message');
    }

    public function test_the_admin_group_update_action_returns_a_successful_response_with_full_removing_muscles(): void
    {
        $groupName = fake()->text(64);
        $group = Group::factory()->create(['name' => $groupName]);

        Muscle::factory()->for($group)->create(['id' => 1]);
        Muscle::factory()->for($group)->create(['id' => 2]);
        Muscle::factory()->for($group)->create(['id' => 3]);
        $muscles = Muscle::whereIn('id', [1, 2, 3])->get();

        $group = $group->refresh();
        $muscles = $muscles->map(fn ($muscle) => $muscle->refresh());

        foreach ($muscles as $muscle) {
            $this->assertTrue($group->muscles->contains($muscle));
        }

        $this->assertTrue(!$group->muscles->isEmpty());

        $response = $this->putJson(route('admin.group.update', $group), [
            'name' => $groupName,
        ]);

        $group = $group->refresh();
        $muscles = $muscles->map(fn ($muscle) => $muscle->refresh());

        $this->assertTrue($group->muscles->isEmpty());

        foreach ($muscles as $muscle) {
            $this->assertTrue($group->muscles->doesntContain($muscle));
        }

        $response
            ->assertSessionDoesntHaveErrors()
            ->assertRedirect(route('admin.group.index'))
            ->assertStatus(302)
            ->assertSessionHas('notification_type', 'success')
            ->assertSessionHas('notification_message');
    }

    public function test_the_admin_group_show_returns_a_successful_response(): void
    {
        $group = Group::factory()->create();

        $response = $this->get(route('admin.group.show', $group));

        $response->assertStatus(200);
    }

    public function test_the_admin_group_show_displayed_groups_and_muscles_name(): void
    {
        $groupName = fake()->text(64);

        $group = Group::factory()->create(['name' => $groupName]);

        $muscles = Muscle::factory(4)->for($group)->create();

        $response = $this->get(route('admin.group.show', $group));

        foreach ($muscles->pluck('name')->toArray() as $name) {
            $response->assertSee($name);
        }

        $response->assertSee($groupName);
    }

    public function test_the_admin_group_delete_action_with_no_muscle_attached_returns_a_successful_response(): void
    {
        $group = Group::factory()->create();

        $response = $this->deleteJson(route('admin.group.destroy', $group));

        $this->assertDatabaseMissing(app(Group::class)->getTable(), [
            'id' => $group->id,
        ]);

        $response
            ->assertSessionDoesntHaveErrors()
            ->assertRedirect(route('admin.group.index'))
            ->assertStatus(302)
            ->assertSessionHas('notification_type', 'success')
            ->assertSessionHas('notification_message');
    }

    public function test_the_admin_group_delete_action_with_muscles_attached_returns_a_successful_response(): void
    {
        $group = Group::factory()->create();

        Muscle::factory(4)->for($group)->create();

        $response = $this->deleteJson(route('admin.group.destroy', $group));

        $this->assertDatabaseHas(app(Group::class)->getTable(), [
            'id' => $group->id,
        ]);

        $response
            ->assertSessionDoesntHaveErrors()
            ->assertRedirect(route('admin.group.index'))
            ->assertStatus(302)
            ->assertSessionHas('notification_type', 'error')
            ->assertSessionHas('notification_message');
    }
}
