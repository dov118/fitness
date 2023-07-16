<?php

namespace Tests\Browser;

use App\Models\Exercise;
use App\Models\Group;
use App\Models\Muscle;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\MuscleControllerShow;
use Tests\DuskTestCase;
use Throwable;

class MuscleControllerShowTest extends DuskTestCase
{
    use DatabaseMigrations;

    private string $userMenuAvatar = '@user-menu-avatar';
    private string $userMenuEmail = '@user-menu-email';

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_show_login_link_not_displayed_on_connected(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user, $muscle) {
            $browser->loginAs($user)
                ->visit(new MuscleControllerShow($muscle))
                ->assertMissing('@header-link-login');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_show_user_menu_displayed_on_connected(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user, $muscle) {
            $browser->loginAs($user)
                ->visit(new MuscleControllerShow($muscle))
                ->assertPresent('@user-menu-avatar');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_show_user_avatar_is_correct(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user, $muscle) {
            $browser->loginAs($user)
                ->visit(new MuscleControllerShow($muscle))
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
    public function test_the_admin_muscle_show_user_menu_open_on_click_on_user_avatar(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user, $muscle) {
            $browser->loginAs($user)
                ->visit(new MuscleControllerShow($muscle))
                ->assertDontSee($user->email)
                ->click($this->userMenuAvatar)
                ->waitForText($user->email)
                ->assertSeeIn($this->userMenuEmail, $user->email);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_show_user_menu_close_on_click_outside_user_menu(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user, $muscle) {
            $browser->loginAs($user)
                ->visit(new MuscleControllerShow($muscle))
                ->assertDontSee($user->email)
                ->click($this->userMenuAvatar)
                ->waitForText($user->email)
                ->assertSeeIn($this->userMenuEmail, $user->email)
                ->clickAtPoint(0, 0)
                ->pause(100)
                ->assertDontSee($user->email);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_show_user_menu_close_on_click_on_opened_user_menu(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user, $muscle) {
            $browser->loginAs($user)
                ->visit(new MuscleControllerShow($muscle))
                ->assertDontSee($user->email)
                ->click($this->userMenuAvatar)
                ->waitForText($user->email)
                ->assertSeeIn($this->userMenuEmail, $user->email)
                ->click($this->userMenuAvatar)
                ->pause(100)
                ->assertDontSee($user->email);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_show_user_menu_contain_dashboard_link(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user, $muscle) {
            $browser->loginAs($user)
                ->visit(new MuscleControllerShow($muscle))
                ->assertDontSee($user->email)
                ->click($this->userMenuAvatar)
                ->waitForText($user->email)
                ->assertSeeIn('@user-menu-dashboard', 'Dashboard');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_show_user_menu_contain_logout_button(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user, $muscle) {
            $browser->loginAs($user)
                ->visit(new MuscleControllerShow($muscle))
                ->assertDontSee($user->email)
                ->click($this->userMenuAvatar)
                ->waitForText($user->email)
                ->assertSeeIn('@user-menu-logout', 'Logout');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_show_user_menu_logged_out_on_logout_button_click(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user, $muscle) {
            $browser->loginAs($user)
                ->visit(new MuscleControllerShow($muscle))
                ->assertDontSee($user->email)
                ->click($this->userMenuAvatar)
                ->waitForText($user->email)
                ->click('@user-menu-logout')
                ->assertRouteIs('login');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_show_sidenav_highlight_current_page(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();

        $this->browse(function (Browser $browser) use ($muscle) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerShow($muscle))
                ->assertPresent('.sidenav .menu-item--muscle[aria-current="page"]');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_show_sidenav_no_highlight_other_pages(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();

        $this->browse(function (Browser $browser) use ($muscle) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerShow($muscle))
                ->assertMissing('.sidenav .menu-item--dashboard[aria-current="page"]')
                ->assertMissing('.sidenav .menu-item--group[aria-current="page"]')
                ->assertMissing('.sidenav .menu-item--exercise[aria-current="page"]');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_show_sidenav_contain_dashboard_link(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();

        $this->browse(function (Browser $browser) use ($muscle) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerShow($muscle))
                ->assertSeeIn('@side-nav-dashboard-link', 'Dashboard');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_show_sidenav_dashboard_link_works(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();

        $this->browse(function (Browser $browser) use ($muscle) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerShow($muscle))
                ->click('@side-nav-dashboard-link')
                ->assertRouteIs('admin.index');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_show_sidenav_contain_muscle_link(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();

        $this->browse(function (Browser $browser) use ($muscle) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerShow($muscle))
                ->assertSeeIn('@side-nav-muscle-link', 'Muscles');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_show_sidenav_muscle_link_contain_counter(): void
    {
        $musclesCount = fake()->numberBetween(1, 12);
        Muscle::factory($musclesCount)->for(Group::factory()->create())->create();

        Group::factory()->create();
        $muscle = Muscle::factory()->create();
        $musclesCount++;

        $this->browse(function (Browser $browser) use ($musclesCount, $muscle) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerShow($muscle))
                ->assertSeeIn('@side-nav-muscle-link-counter', $musclesCount);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_show_sidenav_muscle_link_works(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();

        $this->browse(function (Browser $browser) use ($muscle) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerShow($muscle))
                ->click('@side-nav-muscle-link')
                ->assertRouteIs('admin.muscle.index');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_show_sidenav_contain_group_link(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();

        $this->browse(function (Browser $browser) use ($muscle) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerShow($muscle))
                ->assertSeeIn('@side-nav-group-link', 'Groups');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_show_sidenav_group_link_works(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();

        $this->browse(function (Browser $browser) use ($muscle) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerShow($muscle))
                ->click('@side-nav-group-link')
                ->assertRouteIs('admin.group.index');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_show_sidenav_group_link_contain_counter(): void
    {
        $groupsCount = fake()->numberBetween(1, 12);
        Group::factory($groupsCount)->create();

        Group::factory()->create();
        $muscle = Muscle::factory()->create();
        $groupsCount++;

        $this->browse(function (Browser $browser) use ($groupsCount, $muscle) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerShow($muscle))
                ->assertSeeIn('@side-nav-group-link-counter', $groupsCount);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_show_sidenav_contain_exercise_link(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();

        $this->browse(function (Browser $browser) use ($muscle) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerShow($muscle))
                ->assertSeeIn('@side-nav-exercise-link', 'Exercises');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_show_sidenav_exercise_link_works(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();

        $this->browse(function (Browser $browser) use ($muscle) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerShow($muscle))
                ->click('@side-nav-exercise-link')
                ->assertRouteIs('admin.exercise.index');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_show_sidenav_exercise_link_contain_counter(): void
    {
        $exercisesCount = fake()->numberBetween(1, 12);
        Exercise::factory($exercisesCount)->create();

        Group::factory()->create();
        $muscle = Muscle::factory()->create();

        $this->browse(function (Browser $browser) use ($exercisesCount, $muscle) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerShow($muscle))
                ->assertSeeIn('@side-nav-exercise-link-counter', $exercisesCount);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_show_title_contain_muscle_name(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();

        $this->browse(function (Browser $browser) use ($muscle) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerShow($muscle))
                ->assertSeeIn('@content-title', $muscle->name);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_title_add_button_works(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();

        $this->browse(function (Browser $browser) use ($muscle) {
            $browser->loginAs(User::factory()->create())
                ->visit(new MuscleControllerShow($muscle))
                ->click('@title-edit')
                ->assertRouteIs('admin.muscle.edit', [$muscle]);
        });
    }
}
