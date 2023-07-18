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

    private string $saveButton = '@save-button';

    protected string $page = MuscleControllerCreate::class;

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_create_page_show_required_name_error(): void
    {
        Group::factory(10)->create();
        $muscleRaw = Muscle::factory()->definition();

        $this->browse(function (Browser $browser) use ($muscleRaw) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page())
                ->within(new MuscleControllerCreateForm, function (Browser $browser) use($muscleRaw) {
                    $browser->populate(
                        '',
                        $muscleRaw['fiber_type'],
                        $muscleRaw['group_id'],
                        $muscleRaw['heavy_min'],
                        $muscleRaw['heavy_max'],
                        $muscleRaw['light_min'],
                        $muscleRaw['light_max'],
                        $muscleRaw['max'],
                    );
                })
                ->scrollIntoView($this->saveButton)
                ->click($this->saveButton)
                ->assertRouteIs('admin.muscle.create')
                ->assertPresent('@name-form-with-error')
                ->assertSeeIn('@name-error', 'The name field is required.')
                ->assertInputValue('@name-input', '')
                ->assertMissing('@fiber_type-form-with-error')
                ->assertMissing('@fiber_type-error')
                ->assertSeeIn('@fiber_type-input', $muscleRaw['fiber_type'])
                ->assertMissing('@group_id-form-with-error')
                ->assertMissing('@group_id-error')
                ->assertPresent('.group_id-input option[value="' . $muscleRaw['group_id'] . '"]:checked')
                ->assertMissing('@heavy_min-form-with-error')
                ->assertMissing('@heavy_min-error')
                ->assertInputValue('@heavy_min-input', $muscleRaw['heavy_min'])
                ->assertMissing('@heavy_max-form-with-error')
                ->assertMissing('@heavy_max-error')
                ->assertInputValue('@heavy_max-input', $muscleRaw['heavy_max'])
                ->assertMissing('@light_min-form-with-error')
                ->assertMissing('@light_min-error')
                ->assertInputValue('@light_min-input', $muscleRaw['light_min'])
                ->assertMissing('@light_max-form-with-error')
                ->assertMissing('@light_max-error')
                ->assertInputValue('@light_max-input', $muscleRaw['light_max'])
                ->assertMissing('@max-form-with-error')
                ->assertMissing('@max-error')
                ->assertInputValue('@max-input', $muscleRaw['max']);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_create_page_show_unique_name_error(): void
    {
        Group::factory(10)->create();
        $muscleRaw = Muscle::factory()->definition();
        Muscle::factory()->create($muscleRaw);

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
                ->scrollIntoView($this->saveButton)
                ->click($this->saveButton)
                ->assertRouteIs('admin.muscle.create')
                ->assertPresent('@name-form-with-error')
                ->assertSeeIn('@name-error', 'The name has already been taken.')
                ->assertInputValue('@name-input', $muscleRaw['name'])
                ->assertMissing('@fiber_type-form-with-error')
                ->assertMissing('@fiber_type-error')
                ->assertSeeIn('@fiber_type-input', $muscleRaw['fiber_type'])
                ->assertMissing('@group_id-form-with-error')
                ->assertMissing('@group_id-error')
                ->assertPresent('.group_id-input option[value="' . $muscleRaw['group_id'] . '"]:checked')
                ->assertMissing('@heavy_min-form-with-error')
                ->assertMissing('@heavy_min-error')
                ->assertInputValue('@heavy_min-input', $muscleRaw['heavy_min'])
                ->assertMissing('@heavy_max-form-with-error')
                ->assertMissing('@heavy_max-error')
                ->assertInputValue('@heavy_max-input', $muscleRaw['heavy_max'])
                ->assertMissing('@light_min-form-with-error')
                ->assertMissing('@light_min-error')
                ->assertInputValue('@light_min-input', $muscleRaw['light_min'])
                ->assertMissing('@light_max-form-with-error')
                ->assertMissing('@light_max-error')
                ->assertInputValue('@light_max-input', $muscleRaw['light_max'])
                ->assertMissing('@max-form-with-error')
                ->assertMissing('@max-error')
                ->assertInputValue('@max-input', $muscleRaw['max']);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_create_page_show_length_name_error(): void
    {
        Group::factory(10)->create();
        $muscleRaw = Muscle::factory()->definition();
        $muscleRaw['name'] = \Str::random(65);

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
                ->scrollIntoView($this->saveButton)
                ->click($this->saveButton)
                ->assertRouteIs('admin.muscle.create')
                ->assertPresent('@name-form-with-error')
                ->assertSeeIn('@name-error', 'The name field must not be greater than 64 characters.')
                ->assertInputValue('@name-input', $muscleRaw['name'])
                ->assertMissing('@fiber_type-form-with-error')
                ->assertMissing('@fiber_type-error')
                ->assertSeeIn('@fiber_type-input', $muscleRaw['fiber_type'])
                ->assertMissing('@group_id-form-with-error')
                ->assertMissing('@group_id-error')
                ->assertPresent('.group_id-input option[value="' . $muscleRaw['group_id'] . '"]:checked')
                ->assertMissing('@heavy_min-form-with-error')
                ->assertMissing('@heavy_min-error')
                ->assertInputValue('@heavy_min-input', $muscleRaw['heavy_min'])
                ->assertMissing('@heavy_max-form-with-error')
                ->assertMissing('@heavy_max-error')
                ->assertInputValue('@heavy_max-input', $muscleRaw['heavy_max'])
                ->assertMissing('@light_min-form-with-error')
                ->assertMissing('@light_min-error')
                ->assertInputValue('@light_min-input', $muscleRaw['light_min'])
                ->assertMissing('@light_max-form-with-error')
                ->assertMissing('@light_max-error')
                ->assertInputValue('@light_max-input', $muscleRaw['light_max'])
                ->assertMissing('@max-form-with-error')
                ->assertMissing('@max-error')
                ->assertInputValue('@max-input', $muscleRaw['max']);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_create_page_works_with_only_empty_fiber_type(): void
    {
        Group::factory(10)->create();
        $muscleRaw = Muscle::factory()->definition();
        $muscleRaw['fiber_type'] = '';

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
                ->scrollIntoView($this->saveButton)
                ->click($this->saveButton)
                ->assertRouteIs('admin.muscle.show', [
                    Muscle::find(Muscle::where('name', $muscleRaw['name'])->get()->first()?->id)
                ])
                ->assertSeeIn('@toast-success', 'Muscle successfully created');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_create_page_show_length_fiber_type_error(): void
    {
        Group::factory(10)->create();
        $muscleRaw = Muscle::factory()->definition();
        $muscleRaw['fiber_type'] = \Str::random(256);

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
                ->scrollIntoView($this->saveButton)
                ->click($this->saveButton)
                ->assertRouteIs('admin.muscle.create')
                ->assertMissing('@name-form-with-error')
                ->assertMissing('@name-error')
                ->assertInputValue('@name-input', $muscleRaw['name'])
                ->assertPresent('@fiber_type-form-with-error')
                ->assertSeeIn(
                    '@fiber_type-error',
                    'The fiber type field must not be greater than 255 characters.'
                )
                ->assertSeeIn('@fiber_type-input', $muscleRaw['fiber_type'])
                ->assertMissing('@group_id-form-with-error')
                ->assertMissing('@group_id-error')
                ->assertPresent('.group_id-input option[value="' . $muscleRaw['group_id'] . '"]:checked')
                ->assertMissing('@heavy_min-form-with-error')
                ->assertMissing('@heavy_min-error')
                ->assertInputValue('@heavy_min-input', $muscleRaw['heavy_min'])
                ->assertMissing('@heavy_max-form-with-error')
                ->assertMissing('@heavy_max-error')
                ->assertInputValue('@heavy_max-input', $muscleRaw['heavy_max'])
                ->assertMissing('@light_min-form-with-error')
                ->assertMissing('@light_min-error')
                ->assertInputValue('@light_min-input', $muscleRaw['light_min'])
                ->assertMissing('@light_max-form-with-error')
                ->assertMissing('@light_max-error')
                ->assertInputValue('@light_max-input', $muscleRaw['light_max'])
                ->assertMissing('@max-form-with-error')
                ->assertMissing('@max-error')
                ->assertInputValue('@max-input', $muscleRaw['max']);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_create_page_show_not_exist_group_id_error(): void
    {
        $group = Group::factory(10)->create();
        $muscleRaw = Muscle::factory()->definition();
        $muscleRaw['group_id'] = $group->last()->id + 1;

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
                ->value('.group_id-input option[value="null"]', $muscleRaw['group_id'])
                ->scrollIntoView($this->saveButton)
                ->click($this->saveButton)
                ->assertRouteIs('admin.muscle.create')
                ->assertMissing('@name-form-with-error')
                ->assertMissing('@name-error')
                ->assertInputValue('@name-input', $muscleRaw['name'])
                ->assertMissing('@fiber_type-form-with-error')
                ->assertMissing('@fiber_type-error')
                ->assertSeeIn('@fiber_type-input', $muscleRaw['fiber_type'])
                ->assertPresent('@group_id-form-with-error')
                ->assertSeeIn('@group_id-error', 'The selected group id is invalid.')
                ->assertPresent('.group_id-input option[value="null"]:checked')
                ->assertMissing('@heavy_min-form-with-error')
                ->assertMissing('@heavy_min-error')
                ->assertInputValue('@heavy_min-input', $muscleRaw['heavy_min'])
                ->assertMissing('@heavy_max-form-with-error')
                ->assertMissing('@heavy_max-error')
                ->assertInputValue('@heavy_max-input', $muscleRaw['heavy_max'])
                ->assertMissing('@light_min-form-with-error')
                ->assertMissing('@light_min-error')
                ->assertInputValue('@light_min-input', $muscleRaw['light_min'])
                ->assertMissing('@light_max-form-with-error')
                ->assertMissing('@light_max-error')
                ->assertInputValue('@light_max-input', $muscleRaw['light_max'])
                ->assertMissing('@max-form-with-error')
                ->assertMissing('@max-error')
                ->assertInputValue('@max-input', $muscleRaw['max']);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_create_page_works_with_only_empty_group_id(): void
    {
        Group::factory(10)->create();
        $muscleRaw = Muscle::factory()->definition();
        $muscleRaw['group_id'] = 'null';

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
                ->scrollIntoView($this->saveButton)
                ->click($this->saveButton)
                ->assertRouteIs('admin.muscle.show', [
                    Muscle::find(Muscle::where('name', $muscleRaw['name'])->get()->first()?->id)
                ])
                ->assertSeeIn('@toast-success', 'Muscle successfully created');
        });
    }
}
