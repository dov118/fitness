<?php

namespace Tests\Browser;

use App\Models\Exercise;
use App\Models\Group;
use App\Models\Muscle;
use App\Models\User;
use Laravel\Dusk\Browser;
use Throwable;

trait Sidenav {
    /**
     * @throws Throwable
     */
    public function testTheAdminPageSidenavHighlightCurrentPage(): void
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
    public function testTheAdminPageSidenavNoHighlightOtherPages(): void
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
    public function testTheAdminPageSidenavContainDashboardLink(): void
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
    public function testTheAdminPageSidenavDashboardLinkWorks(): void
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
    public function testTheAdminPageSidenavContainMuscleLink(): void
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
    public function testTheAdminPageSidenavMuscleLinkContainCounter(): void
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
    public function testTheAdminPageSidenavMuscleLinkWorks(): void
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
    public function testTheAdminPageSidenavContainGroupLink(): void
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
    public function testTheAdminPageSidenavGroupLinkWorks(): void
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
    public function testTheAdminPageSidenavGroupLinkContainCounter(): void
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
    public function testTheAdminPageSidenavContainExerciseLink(): void
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
     * @todo error sometimes
     */
    public function testTheAdminPageSidenavExerciseLinkWorks(): void
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
    public function testTheAdminPageSidenavExerciseLinkContainCounter(): void
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
