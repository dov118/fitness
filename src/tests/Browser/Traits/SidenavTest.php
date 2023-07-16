<?php

namespace Tests\Browser\Traits;

use App\Models\Exercise;
use App\Models\Group;
use App\Models\Muscle;
use App\Models\User;
use Laravel\Dusk\Browser;
use Throwable;

trait SidenavTest {
    /**
     * @throws Throwable
     */
    public function test_the_admin_page_sidenav_highlight_current_page(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();

        $this->browse(function (Browser $browser) use ($muscle) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page($muscle))
                ->assertPresent('.sidenav .menu-item--muscle[aria-current="page"]');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_page_sidenav_no_highlight_other_pages(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();

        $this->browse(function (Browser $browser) use ($muscle) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page($muscle))
                ->assertMissing('.sidenav .menu-item--dashboard[aria-current="page"]')
                ->assertMissing('.sidenav .menu-item--group[aria-current="page"]')
                ->assertMissing('.sidenav .menu-item--exercise[aria-current="page"]');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_page_sidenav_contain_dashboard_link(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();

        $this->browse(function (Browser $browser) use ($muscle) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page($muscle))
                ->assertSeeIn('@side-nav-dashboard-link', 'Dashboard');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_page_sidenav_dashboard_link_works(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();

        $this->browse(function (Browser $browser) use ($muscle) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page($muscle))
                ->click('@side-nav-dashboard-link')
                ->assertRouteIs('admin.index');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_page_sidenav_contain_muscle_link(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();

        $this->browse(function (Browser $browser) use ($muscle) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page($muscle))
                ->assertSeeIn('@side-nav-muscle-link', 'Muscles');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_page_sidenav_muscle_link_contain_counter(): void
    {
        $musclesCount = fake()->numberBetween(1, 12);
        Muscle::factory($musclesCount)->for(Group::factory()->create())->create();

        Group::factory()->create();
        $muscle = Muscle::factory()->create();
        $musclesCount++;

        $this->browse(function (Browser $browser) use ($musclesCount, $muscle) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page($muscle))
                ->assertSeeIn('@side-nav-muscle-link-counter', $musclesCount);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_page_sidenav_muscle_link_works(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();

        $this->browse(function (Browser $browser) use ($muscle) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page($muscle))
                ->click('@side-nav-muscle-link')
                ->assertRouteIs('admin.muscle.index');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_page_sidenav_contain_group_link(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();

        $this->browse(function (Browser $browser) use ($muscle) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page($muscle))
                ->assertSeeIn('@side-nav-group-link', 'Groups');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_page_sidenav_group_link_works(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();

        $this->browse(function (Browser $browser) use ($muscle) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page($muscle))
                ->click('@side-nav-group-link')
                ->assertRouteIs('admin.group.index');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_page_sidenav_group_link_contain_counter(): void
    {
        $groupsCount = fake()->numberBetween(1, 12);
        Group::factory($groupsCount)->create();

        Group::factory()->create();
        $muscle = Muscle::factory()->create();
        $groupsCount++;

        $this->browse(function (Browser $browser) use ($groupsCount, $muscle) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page($muscle))
                ->assertSeeIn('@side-nav-group-link-counter', $groupsCount);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_page_sidenav_contain_exercise_link(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();

        $this->browse(function (Browser $browser) use ($muscle) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page($muscle))
                ->assertSeeIn('@side-nav-exercise-link', 'Exercises');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_page_sidenav_exercise_link_works(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();

        $this->browse(function (Browser $browser) use ($muscle) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page($muscle))
                ->click('@side-nav-exercise-link')
                ->assertRouteIs('admin.exercise.index');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_page_sidenav_exercise_link_contain_counter(): void
    {
        $exercisesCount = fake()->numberBetween(1, 12);
        Exercise::factory($exercisesCount)->create();

        Group::factory()->create();
        $muscle = Muscle::factory()->create();

        $this->browse(function (Browser $browser) use ($exercisesCount, $muscle) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page($muscle))
                ->assertSeeIn('@side-nav-exercise-link-counter', $exercisesCount);
        });
    }
}
