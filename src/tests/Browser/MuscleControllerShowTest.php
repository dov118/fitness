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
    use Header;
    use Sidenav;

    protected string $page = MuscleControllerShow::class;

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_show_title_contain_muscle_name(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();

        $this->browse(function (Browser $browser) use ($muscle) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page($muscle))
                ->assertSeeIn('@content-title', $muscle->name);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_show_title_edit_button_works(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();

        $this->browse(function (Browser $browser) use ($muscle) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page($muscle))
                ->click('@title-edit')
                ->assertRouteIs('admin.muscle.edit', [$muscle]);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_show_group_name_is_correct(): void
    {
        $group = Group::factory()->create();
        $muscle = Muscle::factory()->for($group)->create();

        $this->browse(function (Browser $browser) use ($muscle, $group) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page($muscle))
                ->assertSeeIn('@group-name', $group->name);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_show_group_name_link_works(): void
    {
        $group = Group::factory()->create();
        $muscle = Muscle::factory()->for($group)->create();

        $this->browse(function (Browser $browser) use ($muscle, $group) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page($muscle))
                ->click('@group-link')
                ->assertRouteIs('admin.group.show', [$group]);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_show_no_group_not_displaying_group_information(): void
    {
        $muscle = Muscle::factory()->create();

        $this->browse(function (Browser $browser) use ($muscle) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page($muscle))
                ->assertDontSee('Group:')
                ->assertMissing('@group-name')
                ->assertMissing('@group-link');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_show_displaying_exercises_name_in_correct_order(): void
    {
        $muscle = Muscle::factory()->for(Group::factory()->create())->create();

        $exercise1 = Exercise::factory()->hasAttached($muscle, ['intensity' => 0.5])->create();
        $exercise2 = Exercise::factory()->hasAttached($muscle, ['intensity' => 0.25])->create();
        $exercise3 = Exercise::factory()->hasAttached($muscle, ['intensity' => 1.0])->create();

        $muscle = $muscle->refresh();
        $exercise1 = $exercise1->refresh();
        $exercise2 = $exercise2->refresh();
        $exercise3 = $exercise3->refresh();

        $this->browse(function (Browser $browser) use ($muscle, $exercise1, $exercise2, $exercise3) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page($muscle))
                ->assertSeeIn('.exercise-2-name-10', $exercise3->name)
                ->assertSeeIn('.exercise-1-name-05', $exercise1->name)
                ->assertSeeIn('.exercise-0-name-025', $exercise2->name);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_show_not_displaying_exercises_with_zero_intensity(): void
    {
        $muscle = Muscle::factory()->for(Group::factory()->create())->create();

        $exercise1 = Exercise::factory()->hasAttached($muscle, ['intensity' => 0.5])->create();
        $exercise2 = Exercise::factory()->hasAttached($muscle, ['intensity' => 0.0])->create();
        $exercise3 = Exercise::factory()->hasAttached($muscle, ['intensity' => 1.0])->create();

        $muscle = $muscle->refresh();
        $exercise1 = $exercise1->refresh();
        $exercise2 = $exercise2->refresh();
        $exercise3 = $exercise3->refresh();

        $this->browse(function (Browser $browser) use ($muscle, $exercise1, $exercise2, $exercise3) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page($muscle))
                ->assertDontSee($exercise2->name)
                ->assertSeeIn('.exercise-0-name-05', $exercise1->name)
                ->assertSeeIn('.exercise-1-name-10', $exercise3->name);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_show_displaying_exercises_link_works(): void
    {
        $muscle = Muscle::factory()->for(Group::factory()->create())->create();

        $exercise = Exercise::factory()->hasAttached($muscle, ['intensity' => 1.0])->create();

        $muscle = $muscle->refresh();
        $exercise = $exercise->refresh();

        $this->browse(function (Browser $browser) use ($muscle, $exercise) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page($muscle))
                ->click('.exercise-0-link')
                ->assertRouteIs('admin.exercise.show', [$exercise]);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_show_no_exercise_not_displaying_exercise_information(): void
    {
        $muscle = Muscle::factory()->for(Group::factory()->create())->create();

        $muscle = $muscle->refresh();

        $this->browse(function (Browser $browser) use ($muscle) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page($muscle))
                ->assertDontSee('Exercises:');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_show_displaying_correction_heavy_repetitions_information(): void
    {
        $muscle = Muscle::factory()->for(Group::factory()->create())->create();

        $muscle = $muscle->refresh();

        $this->browse(function (Browser $browser) use ($muscle) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page($muscle))
                ->assertSeeIn('@heavy-min', $muscle->heavy_min)
                ->assertSeeIn('@heavy-max', $muscle->heavy_max);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_show_displaying_correction_light_repetitions_information(): void
    {
        $muscle = Muscle::factory()->for(Group::factory()->create())->create();

        $muscle = $muscle->refresh();

        $this->browse(function (Browser $browser) use ($muscle) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page($muscle))
                ->assertSeeIn('@light-min', $muscle->light_min)
                ->assertSeeIn('@light-max', $muscle->light_max);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_show_displaying_correction_max_repetitions_information(): void
    {
        $muscle = Muscle::factory()->for(Group::factory()->create())->create();

        $muscle = $muscle->refresh();

        $this->browse(function (Browser $browser) use ($muscle) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page($muscle))
                ->assertSeeIn('@max', $muscle->max);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_show_displaying_correction_fiber_type_information(): void
    {
        $muscle = Muscle::factory()->for(Group::factory()->create())->create();

        $muscle = $muscle->refresh();

        $this->browse(function (Browser $browser) use ($muscle) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page($muscle))
                ->assertSeeIn('@fiber-type', $muscle->fiber_type);
        });
    }
}
