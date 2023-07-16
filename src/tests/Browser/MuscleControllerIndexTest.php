<?php

namespace Tests\Browser;

use App\Models\Exercise;
use App\Models\Group;
use App\Models\Muscle;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\MuscleControllerIndex;
use Tests\BrowserTraits\SidenavTest;
use Tests\BrowserTraits\HeaderTest;
use Tests\DuskTestCase;
use Throwable;

class MuscleControllerIndexTest extends DuskTestCase
{
    use DatabaseMigrations;
    use HeaderTest;
    use SidenavTest;

    protected string $page = MuscleControllerIndex::class;

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_title_contain_counter(): void
    {
        $musclesCount = fake()->numberBetween(1, 12);
        Muscle::factory($musclesCount)->for(Group::factory()->create())->create();

        $this->browse(function (Browser $browser) use ($musclesCount) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page())
                ->assertSeeIn('@side-nav-muscle-link-counter', $musclesCount)
                ->assertSeeIn('@title-counter', $musclesCount);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_title_contain_add_button(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page())
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
                ->visit(new $this->page())
                ->click('@title-add')
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
                ->visit(new $this->page())
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
                ->visit(new $this->page())
                ->click('.group-0-name')
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
                ->visit(new $this->page())
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
                ->visit(new $this->page())
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
                ->visit(new $this->page())
                ->click('.group-0-muscle-0-link')
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
                ->visit(new $this->page())
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
                ->visit(new $this->page())
                ->click('.group-0-muscle-0-exercise-0-link')
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
                ->visit(new $this->page())
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
                ->visit(new $this->page())
                ->click('.group-0-muscle-0-show-link')
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
                ->visit(new $this->page())
                ->click('.group-0-muscle-0-edit-link')
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
                ->visit(new $this->page())
                ->click('.group-0-muscle-0-delete-link')
                ->assertRouteIs('admin.muscle.index')
                ->assertSeeIn('@toast-success', 'Muscle successfully deleted');
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
                ->visit(new $this->page())
                ->click('.group-0-muscle-0-delete-link')
                ->assertRouteIs('admin.muscle.index')
                ->assertSeeIn('@toast-error', 'Muscle have attached exercise. It can\'t be deleted');
        });
    }
}
