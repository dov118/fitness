<?php

namespace Tests\Browser;

use App\Models\Exercise;
use App\Models\Group;
use App\Models\Muscle;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\MuscleControllerIndex;
use Tests\DuskTestCase;
use Throwable;

class MuscleControllerIndexTest extends DuskTestCase
{
    use DatabaseMigrations;

    private string $userMenuAvatar = '@user-menu-avatar';
    private string $userMenuEmail = '@user-menu-email';

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_login_link_not_displayed_on_connected(): void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit(new MuscleControllerIndex)
                ->assertMissing('@header-link-login');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_user_menu_displayed_on_connected(): void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit(new MuscleControllerIndex)
                ->assertPresent('@user-menu-avatar');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_user_avatar_is_correct(): void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit(new MuscleControllerIndex)
                ->assertAttribute(
                    '@user-menu-avatar-img',
                    'src',
                    'https://cdn.discordapp.com/avatars/' . $user->id . '/' . $user->avatar . '.webp'
                );
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_user_menu_open_on_click_on_user_avatar(): void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit(new MuscleControllerIndex)
                ->assertDontSee($user->email)
                ->click($this->userMenuAvatar)
                ->pause(100)
                ->assertSeeIn($this->userMenuEmail, $user->email);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_user_menu_close_on_click_outside_user_menu(): void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit(new MuscleControllerIndex)
                ->assertDontSee($user->email)
                ->click($this->userMenuAvatar)
                ->pause(100)
                ->assertSeeIn($this->userMenuEmail, $user->email)
                ->clickAtPoint(0, 0)
                ->pause(100)
                ->assertDontSee($user->email);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_user_menu_close_on_click_on_opened_user_menu(): void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit(new MuscleControllerIndex)
                ->assertDontSee($user->email)
                ->click($this->userMenuAvatar)
                ->pause(100)
                ->assertSeeIn($this->userMenuEmail, $user->email)
                ->click($this->userMenuAvatar)
                ->pause(100)
                ->assertDontSee($user->email);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_user_menu_contain_dashboard_link(): void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit(new MuscleControllerIndex)
                ->assertDontSee($user->email)
                ->click($this->userMenuAvatar)
                ->pause(100)
                ->assertSeeIn('@user-menu-dashboard', 'Dashboard');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_user_menu_contain_logout_button(): void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit(new MuscleControllerIndex)
                ->assertDontSee($user->email)
                ->click($this->userMenuAvatar)
                ->pause(100)
                ->assertSeeIn('@user-menu-logout', 'Logout');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_user_menu_logged_out_on_logout_button_click(): void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit(new MuscleControllerIndex)
                ->assertDontSee($user->email)
                ->click($this->userMenuAvatar)
                ->pause(100)
                ->click('@user-menu-logout')
                ->pause(100)
                ->assertRouteIs('login');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_sidenav_highlight_current_page(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerIndex)
                ->assertPresent('.sidenav .menu-item--muscle[aria-current="page"]');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_sidenav_no_highlight_other_pages(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerIndex)
                ->assertMissing('.sidenav .menu-item--dashboard[aria-current="page"]')
                ->assertMissing('.sidenav .menu-item--group[aria-current="page"]')
                ->assertMissing('.sidenav .menu-item--exercise[aria-current="page"]');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_sidenav_contain_dashboard_link(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerIndex)
                ->assertSeeLink('Dashboard');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_sidenav_dashboard_link_works(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerIndex)
                ->click('@side-nav-dashboard-link')
                ->pause(100)
                ->assertRouteIs('admin.index');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_sidenav_contain_muscle_link(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerIndex)
                ->assertSeeLink('Muscles');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_sidenav_muscle_link_contain_counter(): void
    {
        $muscles_count = fake()->numberBetween(1, 12);
        Muscle::factory($muscles_count)->for(Group::factory()->create())->create();

        $this->browse(function (Browser $browser) use ($muscles_count) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerIndex)
                ->assertSeeIn('@side-nav-muscle-link-counter', $muscles_count);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_sidenav_muscle_link_works(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerIndex)
                ->click('@side-nav-muscle-link')
                ->pause(100)
                ->assertRouteIs('admin.muscle.index');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_sidenav_contain_group_link(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerIndex)
                ->assertSeeLink('Groups');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_sidenav_group_link_works(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerIndex)
                ->click('@side-nav-group-link')
                ->pause(100)
                ->assertRouteIs('admin.group.index');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_sidenav_group_link_contain_counter(): void
    {
        $groups_count = fake()->numberBetween(1, 12);
        Group::factory($groups_count)->create();

        $this->browse(function (Browser $browser) use ($groups_count) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerIndex)
                ->assertSeeIn('@side-nav-group-link-counter', $groups_count);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_sidenav_contain_exercise_link(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerIndex)
                ->assertSeeLink('Exercises');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_sidenav_exercise_link_works(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerIndex)
                ->click('@side-nav-exercise-link')
                ->pause(100)
                ->assertRouteIs('admin.exercise.index');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_sidenav_exercise_link_contain_counter(): void
    {
        $exercises_count = fake()->numberBetween(1, 12);
        Exercise::factory($exercises_count)->create();

        $this->browse(function (Browser $browser) use ($exercises_count) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerIndex)
                ->assertSeeIn('@side-nav-exercise-link-counter', $exercises_count);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_title_contain_counter(): void
    {
        $muscles_count = fake()->numberBetween(1, 12);
        Muscle::factory($muscles_count)->for(Group::factory()->create())->create();

        $this->browse(function (Browser $browser) use ($muscles_count) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerIndex)
                ->assertSeeIn('@side-nav-muscle-link-counter', $muscles_count)
                ->assertSeeIn('@title-counter', $muscles_count);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_title_contain_add_button(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerIndex)
                ->assertPresent('@title-add');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_title_add_button_works(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerIndex)
                ->click('@title-add')
                ->pause(100)
                ->assertRouteIs('admin.muscle.create');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_content_group_sort_by_name(): void
    {
        $group1 = Group::factory()->create(['id' => 1, 'name' => 'A' . fake()->text(63)]);
        $group2 = Group::factory()->create(['id' => 2, 'name' => 'C' . fake()->text(63)]);
        $group3 = Group::factory()->create(['id' => 3, 'name' => 'B' . fake()->text(63)]);

        Muscle::factory(2)->for($group1)->create();
        Muscle::factory(2)->for($group2)->create();
        Muscle::factory(2)->for($group3)->create();

        $this->browse(function (Browser $browser) use ($group1, $group2, $group3) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerIndex)
                ->assertSeeIn('.group-0-name', $group1->name)
                ->assertSeeIn('.group-1-name', $group3->name)
                ->assertSeeIn('.group-2-name', $group2->name);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_content_group_name_link_works(): void
    {
        $group = Group::factory()->create();

        $this->browse(function (Browser $browser) use ($group) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerIndex)
                ->click('.group-0-name')
                ->pause(100)
                ->assertRouteIs('admin.group.show', [$group]);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_content_group_contain_counter(): void
    {
        $group1 = Group::factory()->create(['id' => 1, 'name' => 'A' . fake()->text(63)]);
        $group2 = Group::factory()->create(['id' => 2, 'name' => 'C' . fake()->text(63)]);
        $group3 = Group::factory()->create(['id' => 3, 'name' => 'B' . fake()->text(63)]);

        Muscle::factory(fake()->numberBetween(1, 4))->for($group1)->create();
        Muscle::factory(fake()->numberBetween(1, 4))->for($group2)->create();
        Muscle::factory(fake()->numberBetween(1, 4))->for($group3)->create();

        $group1 = $group1->refresh();
        $group2 = $group2->refresh();
        $group3 = $group3->refresh();

        $this->browse(function (Browser $browser) use ($group1, $group2, $group3) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerIndex)
                ->assertSeeIn('.group-0-counter', $group1->muscles->count())
                ->assertSeeIn('.group-1-counter', $group3->muscles->count())
                ->assertSeeIn('.group-2-counter', $group2->muscles->count());
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_content_group_muscles_sort_by_name(): void
    {
        $group = Group::factory()->create();

        $muscle1 = Muscle::factory()->for($group)->create(['id' => 1, 'name' => 'A' . fake()->text(63)]);
        $muscle2 = Muscle::factory()->for($group)->create(['id' => 2, 'name' => 'D' . fake()->text(63)]);
        $muscle3 = Muscle::factory()->for($group)->create(['id' => 3, 'name' => 'C' . fake()->text(63)]);
        $muscle4 = Muscle::factory()->for($group)->create(['id' => 4, 'name' => 'B' . fake()->text(63)]);

        $muscle1 = $muscle1->refresh();
        $muscle2 = $muscle2->refresh();
        $muscle3 = $muscle3->refresh();
        $muscle4 = $muscle4->refresh();

        $this->browse(function (Browser $browser) use ($muscle1, $muscle2, $muscle3, $muscle4) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerIndex)
                ->assertSeeIn('.group-0-muscle-0-name', $muscle1->name)
                ->assertSeeIn('.group-0-muscle-1-name', $muscle4->name)
                ->assertSeeIn('.group-0-muscle-2-name', $muscle3->name)
                ->assertSeeIn('.group-0-muscle-3-name', $muscle2->name);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_content_group_muscles_name_link_works(): void
    {
        $muscle = Muscle::factory()->for(Group::factory()->create())->create();

        $this->browse(function (Browser $browser) use ($muscle) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerIndex)
                ->click('.group-0-muscle-0-link')
                ->pause(100)
                ->assertRouteIs('admin.muscle.show', [$muscle]);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_content_group_muscles_exercises_correctly_sorted(): void
    {
        $muscle = Muscle::factory()->for(Group::factory()->create())->create();

        $exercise1 = Exercise::factory()->hasAttached($muscle, ['intensity' => 0.25])->create();
        $exercise2 = Exercise::factory()->hasAttached($muscle, ['intensity' => 1])->create();
        $exercise3 = Exercise::factory()->hasAttached($muscle, ['intensity' => 0.5])->create();

        $exercise1 = $exercise1->refresh();
        $exercise2 = $exercise2->refresh();
        $exercise3 = $exercise3->refresh();

        $this->browse(function (Browser $browser) use ($exercise1, $exercise2, $exercise3) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerIndex)
                ->assertSeeIn('.group-0-muscle-0-exercise-0-name--1', $exercise2->name)
                ->assertSeeIn('.group-0-muscle-0-exercise-1-name--05', $exercise3->name)
                ->assertSeeIn('.group-0-muscle-0-exercise-2-name--025', $exercise1->name);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_content_group_muscles_exercise_link_works(): void
    {
        $exercise = Exercise::factory()->hasAttached(
            Muscle::factory()->for(Group::factory()->create())->create(), ['intensity' => 1]
        )->create();

        $this->browse(function (Browser $browser) use ($exercise) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerIndex)
                ->click('.group-0-muscle-0-exercise-0-link')
                ->pause(100)
                ->assertRouteIs('admin.exercise.show', [$exercise]);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_content_group_muscles_exercises_zero_intensity_not_displayed(): void
    {
        $muscle = Muscle::factory()->for(Group::factory()->create())->create();

        $exercise1 = Exercise::factory()->hasAttached($muscle, ['intensity' => 0])->create();
        $exercise2 = Exercise::factory()->hasAttached($muscle, ['intensity' => 1])->create();
        $exercise3 = Exercise::factory()->hasAttached($muscle, ['intensity' => 0.5])->create();

        $exercise1 = $exercise1->refresh();
        $exercise2 = $exercise2->refresh();
        $exercise3 = $exercise3->refresh();

        $this->browse(function (Browser $browser) use ($exercise1, $exercise2, $exercise3) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerIndex)
                ->assertSeeIn('.group-0-muscle-0-exercise-0-name--1', $exercise2->name)
                ->assertSeeIn('.group-0-muscle-0-exercise-1-name--05', $exercise3->name)
                ->assertDontSeeIn('.group-0-muscle-0', $exercise1->name);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_content_group_muscles_show_link_works(): void
    {
        $muscle = Muscle::factory()->for(Group::factory()->create())->create();
        Exercise::factory(3)->hasAttached($muscle)->create();

        $muscle = $muscle->refresh();

        $this->browse(function (Browser $browser) use ($muscle) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerIndex)
                ->click('.group-0-muscle-0-show-link')
                ->pause(100)
                ->assertRouteIs('admin.muscle.show', [$muscle]);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_content_group_muscles_edit_link_works(): void
    {
        $muscle = Muscle::factory()->for(Group::factory()->create())->create();
        Exercise::factory(3)->hasAttached($muscle)->create();

        $muscle = $muscle->refresh();

        $this->browse(function (Browser $browser) use ($muscle) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerIndex)
                ->click('.group-0-muscle-0-edit-link')
                ->pause(100)
                ->assertRouteIs('admin.muscle.edit', [$muscle]);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_content_group_muscles_delete_link_for_unattached_exercises_works(): void
    {
        Muscle::factory()->for(Group::factory()->create())->create();

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerIndex)
                ->click('.group-0-muscle-0-delete-link')
                ->pause(100)
                ->assertRouteIs('admin.muscle.index')
                ->assertSeeIn('.Toast.Toast--success', 'Muscle successfully deleted');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_content_group_muscles_delete_link_for_attached_exercises_works(): void
    {
        $muscle = Muscle::factory()->for(Group::factory()->create())->create();
        Exercise::factory(3)->hasAttached($muscle, ['intensity' => 1.0])->create();

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerIndex)
                ->click('.group-0-muscle-0-delete-link')
                ->pause(100)
                ->assertRouteIs('admin.muscle.index')
                ->assertSeeIn(
                    '.Toast.Toast--error',
                    'Muscle have attached exercise. It can\'t be deleted'
                );
        });
    }
}
