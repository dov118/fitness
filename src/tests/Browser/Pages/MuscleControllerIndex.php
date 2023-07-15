<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;

class MuscleControllerIndex extends Page
{
    /**
     * Get the URL for the page.
     */
    public function url(): string
    {
        return route('admin.muscle.index', [], false);
    }

    /**
     * Assert that the browser is on the page.
     */
    public function assert(Browser $browser): void
    {
        $browser->assertPathIs($this->url());
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array<string, string>
     */
    public function elements(): array
    {
        return [
            '@user-menu-avatar' => '.user-menu-avatar',
            '@user-menu-email' => '.user-menu-email',
            '@user-menu-dashboard' => '.user-menu-dashboard',
            '@user-menu-logout' => '.user-menu-logout',
            '@side-nav-general-group-title' => '.sidenav .menu-heading--general',
            '@side-nav-muscle-group-title' => '.sidenav .menu-heading--muscle',
            '@side-nav-exercise-group-title' => '.sidenav .menu-heading--exercise',
        ];
    }
}
