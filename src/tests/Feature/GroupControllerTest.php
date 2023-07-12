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
        $group_name = fake()->text(64);

        $group = Group::factory()->create(['name' => $group_name]);

        $muscles = Muscle::factory(4)->for($group)->create();

        $response = $this->get(route('admin.group.index'));

        foreach ($muscles->pluck('name')->toArray() as $name) {
            $response->assertSee($name);
        }

        $response->assertSee($group_name);
    }

    public function test_the_admin_group_create_page_returns_a_successful_response(): void
    {
        $response = $this->get(route('admin.group.create'));

        $response->assertStatus(200);
    }

    public function test_the_admin_group_create_action_returns_a_successful_response(): void
    {
        $group_name = fake()->text(64);

        $response = $this->postJson(route('admin.group.store'), [
            'name' => $group_name,
        ]);

        $this->assertDatabaseHas(app(Group::class)->getTable(), [
            'name' => $group_name,
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
        $group_name = fake()->text(64);
        $group = Group::factory()->create(['name' => $group_name]);

        $this->assertTrue(Group::find($group->id)->name === $group_name);

        $group_name = fake()->text(64);

        $response = $this->putJson(route('admin.group.update', $group), [
            'name' => $group_name,
        ]);

        $this->assertTrue(Group::find($group->id)->name === $group_name);

        $response
            ->assertSessionDoesntHaveErrors()
            ->assertRedirect(route('admin.group.index'))
            ->assertStatus(302)
            ->assertSessionHas('notification_type', 'success')
            ->assertSessionHas('notification_message');
    }

    public function test_the_admin_group_update_action_returns_an_error_if_new_name_already_used(): void
    {
        $other_group_name = fake()->text(64);
        Group::factory()->create(['name' => $other_group_name]);

        $group_name = fake()->text(64);
        $group = Group::factory()->create(['name' => $group_name]);

        $this->assertTrue(Group::find($group->id)->name === $group_name);

        $response = $this->putJson(route('admin.group.update', $group), [
            'name' => $other_group_name,
        ]);

        $response
            ->assertSessionMissing('name')
            ->assertStatus(422);
    }

    public function test_the_admin_group_update_action_returns_a_successful_response_with_full_muscle_changes(): void
    {
        $group_name = fake()->text(64);
        $group = Group::factory()->create(['name' => $group_name]);

        Muscle::factory()->for($group)->create(['id' => 1]);
        Muscle::factory()->for($group)->create(['id' => 2]);
        Muscle::factory()->for($group)->create(['id' => 3]);

        Muscle::factory()->create(['id' => 4, 'group_id' => null]);
        Muscle::factory()->create(['id' => 5, 'group_id' => null]);
        Muscle::factory()->create(['id' => 6, 'group_id' => null]);

        $old_muscles = Muscle::whereIn('id', [1, 2, 3])->get();
        $new_muscles = Muscle::whereIn('id', [4, 5, 6])->get();

        $params = [];
        $params['name'] = $group_name;

        $group = $group->refresh();
        $old_muscles = $old_muscles->map(fn ($muscle) => $muscle->refresh());
        $new_muscles = $new_muscles->map(fn ($muscle) => $muscle->refresh());

        foreach ($old_muscles as $muscle) {
            $this->assertTrue($group->muscles->contains($muscle));
        }

        foreach ($new_muscles as $muscle) {
            $this->assertTrue($group->muscles->doesntContain($muscle));
            $params['muscle_' . $muscle->id] = 'on';
        }

        $response = $this->putJson(route('admin.group.update', $group), $params);

        $group = $group->refresh();
        $old_muscles = $old_muscles->map(fn ($muscle) => $muscle->refresh());
        $new_muscles = $new_muscles->map(fn ($muscle) => $muscle->refresh());

        foreach ($old_muscles as $muscle) {
            $this->assertTrue($group->muscles->doesntContain($muscle));
        }

        foreach ($new_muscles as $muscle) {
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
        $group_name = fake()->text(64);
        $group = Group::factory()->create(['name' => $group_name]);

        Muscle::factory()->for($group)->create(['id' => 1]);
        Muscle::factory()->for($group)->create(['id' => 2]);
        Muscle::factory()->for($group)->create(['id' => 3]);

        Muscle::factory()->create(['id' => 4, 'group_id' => null]);

        $old_muscles = Muscle::whereIn('id', [1, 2, 3])->get();
        $new_muscles = Muscle::whereIn('id', [4])->get();

        $params = [];
        $params['name'] = $group_name;

        $group = $group->refresh();
        $old_muscles = $old_muscles->map(fn ($muscle) => $muscle->refresh());
        $new_muscles = $new_muscles->map(fn ($muscle) => $muscle->refresh());

        foreach ($old_muscles as $muscle) {
            $this->assertTrue($group->muscles->contains($muscle));
            $params['muscle_' . $muscle->id] = 'on';
        }

        foreach ($new_muscles as $muscle) {
            $this->assertTrue($group->muscles->doesntContain($muscle));
            $params['muscle_' . $muscle->id] = 'on';
        }

        $response = $this->putJson(route('admin.group.update', $group), $params);

        $group = $group->refresh();
        $old_muscles = $old_muscles->map(fn ($muscle) => $muscle->refresh());
        $new_muscles = $new_muscles->map(fn ($muscle) => $muscle->refresh());

        foreach ($old_muscles as $muscle) {
            $this->assertTrue($group->muscles->contains($muscle));
        }

        foreach ($new_muscles as $muscle) {
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
        $group_name = fake()->text(64);
        $group = Group::factory()->create(['name' => $group_name]);

        Muscle::factory()->for($group)->create(['id' => 1]);
        Muscle::factory()->for($group)->create(['id' => 2]);
        $removing_muscle = Muscle::factory()->for($group)->create(['id' => 3]);

        $remaining_muscles = Muscle::whereIn('id', [1, 2])->get();

        $params = [];
        $params['name'] = $group_name;

        $group = $group->refresh();
        $removing_muscle = $removing_muscle->refresh();
        $remaining_muscles = $remaining_muscles->map(fn ($muscle) => $muscle->refresh());

        foreach ($remaining_muscles as $muscle) {
            $this->assertTrue($group->muscles->contains($muscle));
            $params['muscle_' . $muscle->id] = 'on';
        }
        $this->assertTrue($group->muscles->contains($removing_muscle));

        $response = $this->putJson(route('admin.group.update', $group), $params);

        $group = $group->refresh();
        $removing_muscle = $removing_muscle->refresh();
        $remaining_muscles = $remaining_muscles->map(fn ($muscle) => $muscle->refresh());

        foreach ($remaining_muscles as $muscle) {
            $this->assertTrue($group->muscles->contains($muscle));
        }
        $this->assertTrue($group->muscles->doesntContain($removing_muscle));

        $response
            ->assertSessionDoesntHaveErrors()
            ->assertRedirect(route('admin.group.index'))
            ->assertStatus(302)
            ->assertSessionHas('notification_type', 'success')
            ->assertSessionHas('notification_message');
    }

    public function test_the_admin_group_update_action_returns_a_successful_response_with_full_adding_muscles(): void
    {
        $group_name = fake()->text(64);
        $group = Group::factory()->create(['name' => $group_name]);

        Muscle::factory()->create(['id' => 1, 'group_id' => null]);
        Muscle::factory()->create(['id' => 2, 'group_id' => null]);
        Muscle::factory()->create(['id' => 3, 'group_id' => null]);
        $muscles = Muscle::whereIn('id', [1, 2, 3])->get();

        $params = [];
        $params['name'] = $group_name;

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
        $group_name = fake()->text(64);
        $group = Group::factory()->create(['name' => $group_name]);

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
            'name' => $group_name,
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
        $group_name = fake()->text(64);

        $group = Group::factory()->create(['name' => $group_name]);

        $muscles = Muscle::factory(4)->for($group)->create();

        $response = $this->get(route('admin.group.show', $group));

        foreach ($muscles->pluck('name')->toArray() as $name) {
            $response->assertSee($name);
        }

        $response->assertSee($group_name);
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
