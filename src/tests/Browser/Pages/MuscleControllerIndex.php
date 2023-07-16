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
            '@header-link-login' => '.Header-link--login',
            '@user-menu-avatar' => '.user-menu-avatar',
            '@user-menu-avatar-img' => '.user-menu-avatar img',
            '@user-menu-email' => '.user-menu-email',
            '@user-menu-dashboard' => '.user-menu-dashboard',
            '@user-menu-logout' => '.user-menu-logout',
            '@side-nav-general-group-title' => '.sidenav .menu-heading--general',
            '@side-nav-dashboard-link' => '.sidenav .menu-item--dashboard',
            '@side-nav-muscle-link' => '.sidenav .menu-item--muscle',
            '@side-nav-muscle-link-counter' => '.sidenav .menu-item--muscle-count',
            '@side-nav-group-link' => '.sidenav .menu-item--group',
            '@side-nav-group-link-counter' => '.sidenav .menu-item--group-count',
            '@side-nav-exercise-link' => '.sidenav .menu-item--exercise',
            '@side-nav-exercise-link-counter' => '.sidenav .menu-item--exercise-count',
            '@title-counter' => '.title-counter',
            '@title-add' => '.title-add',
        ];
    }
}
