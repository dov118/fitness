<?php

namespace Tests\BrowserTraits;

use App\Models\Group;
use App\Models\Muscle;
use App\Models\User;
use Laravel\Dusk\Browser;
use Throwable;

trait HeaderTest {
    private string $userMenuAvatar = '@user-menu-avatar';
    private string $userMenuEmail = '@user-menu-email';

    /**
     * @throws Throwable
     */
    public function test_the_admin_page_login_link_not_displayed_on_connected(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user, $muscle) {
            $browser->loginAs($user)
                ->visit(new $this->page($muscle))
                ->assertMissing('@header-link-login');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_page_user_menu_displayed_on_connected(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user, $muscle) {
            $browser->loginAs($user)
                ->visit(new $this->page($muscle))
                ->assertPresent('@user-menu-avatar');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_page_user_avatar_is_correct(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user, $muscle) {
            $browser->loginAs($user)
                ->visit(new $this->page($muscle))
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
    public function test_the_admin_page_user_menu_open_on_click_on_user_avatar(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user, $muscle) {
            $browser->loginAs($user)
                ->visit(new $this->page($muscle))
                ->assertDontSee($user->email)
                ->click($this->userMenuAvatar)
                ->waitForText($user->email)
                ->assertSeeIn($this->userMenuEmail, $user->email);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_page_user_menu_close_on_click_outside_user_menu(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user, $muscle) {
            $browser->loginAs($user)
                ->visit(new $this->page($muscle))
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
    public function test_the_admin_page_user_menu_close_on_click_on_opened_user_menu(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user, $muscle) {
            $browser->loginAs($user)
                ->visit(new $this->page($muscle))
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
    public function test_the_admin_page_user_menu_contain_dashboard_link(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user, $muscle) {
            $browser->loginAs($user)
                ->visit(new $this->page($muscle))
                ->assertDontSee($user->email)
                ->click($this->userMenuAvatar)
                ->waitForText($user->email)
                ->assertSeeIn('@user-menu-dashboard', 'Dashboard');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_page_user_menu_contain_logout_button(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user, $muscle) {
            $browser->loginAs($user)
                ->visit(new $this->page($muscle))
                ->assertDontSee($user->email)
                ->click($this->userMenuAvatar)
                ->waitForText($user->email)
                ->assertSeeIn('@user-menu-logout', 'Logout');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_page_user_menu_logged_out_on_logout_button_click(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user, $muscle) {
            $browser->loginAs($user)
                ->visit(new $this->page($muscle))
                ->assertDontSee($user->email)
                ->click($this->userMenuAvatar)
                ->waitForText($user->email)
                ->click('@user-menu-logout')
                ->assertRouteIs('login');
        });
    }
}
