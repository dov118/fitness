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
        $first_group_name = fake()->text(64);
        Group::factory()->create(['name' => $first_group_name]);

        $group_name = fake()->text(64);
        $group = Group::factory()->create(['name' => $group_name]);

        $this->putJson(route('admin.group.update', $group), [
            'name' => $first_group_name,
        ]);

        $response = $this->putJson(route('admin.group.update', $group), [
            'name' => $group_name,
        ]);

        $response
            ->assertSessionMissing('name')
            ->assertStatus(302);
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
