<?php

namespace Tests\Browser;

use App\Models\Group;
use App\Models\Muscle;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Components\MuscleControllerCreateForm;
use Tests\Browser\Pages\MuscleControllerCreate;
use Tests\DuskTestCase;
use Throwable;

class MuscleControllerCreateTest extends DuskTestCase
{
    use DatabaseMigrations;
    use Header;
    use Sidenav;

    protected string $page = MuscleControllerCreate::class;

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_create_page_works_with_correct_data(): void
    {
        Group::factory(10)->create();
        $muscleRaw = Muscle::factory()->definition();

        $this->browse(function (Browser $browser) use ($muscleRaw) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page())
                ->within(new MuscleControllerCreateForm, function (Browser $browser) use($muscleRaw) {
                    $browser->populate(
                        $muscleRaw['name'],
                        $muscleRaw['fiber_type'],
                        $muscleRaw['group_id'],
                        $muscleRaw['heavy_min'],
                        $muscleRaw['heavy_max'],
                        $muscleRaw['light_min'],
                        $muscleRaw['light_max'],
                        $muscleRaw['max'],
                    );
                })
                ->scrollIntoView('@save-button')
                ->click('@save-button')
                ->assertRouteIs('admin.muscle.show', [
                    Muscle::find(Muscle::where('name', $muscleRaw['name'])->get()->all()[0]->id)
                ])
                ->assertSeeIn('@toast-success', 'Muscle successfully created');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_create_page_works_with_only_required_data(): void
    {
        Group::factory(10)->create();
        $muscleRaw = Muscle::factory()->definition();

        $this->browse(function (Browser $browser) use ($muscleRaw) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page())
                ->within(new MuscleControllerCreateForm, function (Browser $browser) use($muscleRaw) {
                    $browser->populate(
                        $muscleRaw['name'],
                        '',
                        'null',
                        '',
                        '',
                        '',
                        '',
                        '',
                    );
                })
                ->scrollIntoView('@save-button')
                ->click('@save-button')
                ->assertRouteIs('admin.muscle.show', [
                    Muscle::find(Muscle::where('name', $muscleRaw['name'])->get()->all()[0]->id)
                ])
                ->assertSeeIn('@toast-success', 'Muscle successfully created');
        });
    }
}
