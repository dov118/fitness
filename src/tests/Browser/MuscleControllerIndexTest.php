<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Throwable;

class MuscleControllerIndexTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_user_menu_open_on_click_on_user_avatar(): void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visitRoute('admin.muscle.index')
                ->assertDontSee($user->email)
                ->click('.user-menu-avatar')
                ->pause(100)
                ->assertSeeIn('.user-menu-email', $user->email);
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
                ->visitRoute('admin.muscle.index')
                ->assertDontSee($user->email)
                ->click('.user-menu-avatar')
                ->pause(100)
                ->assertSeeIn('.user-menu-email', $user->email)
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
                ->visitRoute('admin.muscle.index')
                ->assertDontSee($user->email)
                ->click('.user-menu-avatar')
                ->pause(100)
                ->assertSeeIn('.user-menu-email', $user->email)
                ->click('.user-menu-avatar')
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
                ->visitRoute('admin.muscle.index')
                ->assertDontSee($user->email)
                ->click('.user-menu-avatar')
                ->pause(100)
                ->assertSeeIn('.user-menu-dashboard', 'Dashboard');
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
                ->visitRoute('admin.muscle.index')
                ->assertDontSee($user->email)
                ->click('.user-menu-avatar')
                ->pause(100)
                ->assertSeeIn('.user-menu-logout', 'Logout');
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
                ->visitRoute('admin.muscle.index')
                ->assertDontSee($user->email)
                ->click('.user-menu-avatar')
                ->pause(100)
                ->click('.user-menu-logout')
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
                ->visitRoute('admin.muscle.index')
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
                ->visitRoute('admin.muscle.index')
                ->assertMissing('.sidenav .menu-item--group[aria-current="page"]');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_sidenav_general_group_contain_title(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::factory()->create())
                ->visitRoute('admin.muscle.index')
                ->assertSeeIn('.sidenav .menu-heading--general', 'General');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_sidenav_general_group_contain_dashboard_link(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::factory()->create())
                ->visitRoute('admin.muscle.index')
                ->assertSeeLink('Dashboard');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_sidenav_muscle_group_no_title(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::factory()->create())
                ->visitRoute('admin.muscle.index')
                ->assertMissing('.sidenav .menu-heading--muscle');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_sidenav_muscle_group_contain_muscle_link(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::factory()->create())
                ->visitRoute('admin.muscle.index')
                ->assertSeeLink('Muscles');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_sidenav_muscle_group_contain_group_link(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::factory()->create())
                ->visitRoute('admin.muscle.index')
                ->assertSeeLink('Groups');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_sidenav_exercise_group_no_title(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::factory()->create())
                ->visitRoute('admin.muscle.index')
                ->assertMissing('.sidenav .menu-heading--exercise');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_sidenav_exercise_group_contain_exercise_link(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::factory()->create())
                ->visitRoute('admin.muscle.index')
                ->assertSeeLink('Exercises');
        });
    }
}
