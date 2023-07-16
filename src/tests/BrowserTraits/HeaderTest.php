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
    public function testTheAdminPageLoginLinkNotDisplayedOnConnected(): void
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
    public function testTheAdminPageUserMenuDisplayedOnConnected(): void
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
    public function testTheAdminPageUserAvatarIsCorrect(): void
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
    public function testTheAdminPageUserMenuOpenOnClickOnUserAvatar(): void
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
    public function testTheAdminPageUserMenuCloseOnClickOutsideUserMenu(): void
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
    public function testTheAdminPageUserMenuCloseOnClickOnOpenedUserMenu(): void
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
    public function testTheAdminPageUserMenuContainDashboardLink(): void
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
    public function testTheAdminPageUserMenuContainLogoutButton(): void
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
    public function testTheAdminPageUserMenuLoggedOutOnLogoutButtonClick(): void
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
