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
                ->assertAttribute('@user-menu-avatar-img', 'src', 'https://cdn.discordapp.com/avatars/' . $user->id . '/' . $user->avatar . '.webp');
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
}
