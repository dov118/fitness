<?php

namespace Tests\Browser;

use App\Models\Exercise;
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
    private string $nameFormWithError = '@name-form-with-error';
    private string $nameError = '@name-error';
    private string $nameInput = '@name-input';
    private string $fiberTypeFormWithError = '@fiber_type-form-with-error';
    private string $fiberTypeError = '@fiber_type-error';
    private string $fiberTypeInput = '@fiber_type-input';
    private string $groupIdFormWithError = '@group_id-form-with-error';
    private string $groupIdError = '@group_id-error';
    private string $heavyMinFormWithError = '@heavy_min-form-with-error';
    private string $heavyMinError = '@heavy_min-error';
    private string $heavyMinInput = '@heavy_min-input';
    private string $heavyMaxFormWithError = '@heavy_max-form-with-error';
    private string $heavyMaxError = '@heavy_max-error';
    private string $heavyMaxInput = '@heavy_max-input';
    private string $lightMinFormWithError = '@light_min-form-with-error';
    private string $lightMinError = '@light_min-error';
    private string $lightMinInput = '@light_min-input';
    private string $lightMaxFormWithError = '@light_max-form-with-error';
    private string $lightMaxError = '@light_max-error';
    private string $lightMaxInput = '@light_max-input';
    private string $maxFormWithError = '@max-form-with-error';
    private string $maxError = '@max-error';
    private string $maxInput = '@max-input';

    protected string $page = MuscleControllerCreate::class;

    private function getOptionSelectorByValue(string $value): string
    {
        return '.group_id-input option[value="' . $value . '"]:checked';
    }

    private function getMuscleRadioSelector(Exercise $exercise, string $intensity): string
    {
        return '.exercise-' . $exercise->id . '-form input[value="' . $intensity . '"]:checked';
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_create_page_show_required_name_error(): void
    {
        Group::factory(10)->create();
        $exercise1 = Exercise::factory()->create();
        $exercise2 = Exercise::factory()->create();
        $exercise3 = Exercise::factory()->create();
        $exercise4 = Exercise::factory()->create();
        $exercise1Intensity = "0.5";
        $exercise2Intensity = "0.0";
        $exercise3Intensity = "1.0";
        $exercise4Intensity = "0.25";
        $muscleRaw = Muscle::factory()->definition();

        $this->browse(function (Browser $browser) use ($muscleRaw, $exercise1, $exercise2, $exercise3, $exercise4,
            $exercise1Intensity, $exercise2Intensity, $exercise3Intensity, $exercise4Intensity) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page())
                ->within(new MuscleControllerCreateForm, function (Browser $browser) use($muscleRaw, $exercise1,
                    $exercise2, $exercise3, $exercise4, $exercise1Intensity, $exercise2Intensity, $exercise3Intensity,
                    $exercise4Intensity) {
                    $browser->populate(
                        '',
                        $muscleRaw['fiber_type'],
                        $muscleRaw['group_id'],
                        $muscleRaw['heavy_min'],
                        $muscleRaw['heavy_max'],
                        $muscleRaw['light_min'],
                        $muscleRaw['light_max'],
                        $muscleRaw['max'],
                        $exercise1,
                        $exercise1Intensity,
                        $exercise2,
                        $exercise2Intensity,
                        $exercise3,
                        $exercise3Intensity,
                        $exercise4,
                        $exercise4Intensity,
                    );
                })
                ->scrollIntoView($this->saveButton)
                ->click($this->saveButton)
                ->assertRouteIs('admin.muscle.create')
                ->assertPresent($this->nameFormWithError)
                ->assertSeeIn($this->nameError, 'The name field is required.')
                ->assertInputValue($this->nameInput, '')
                ->assertMissing($this->fiberTypeFormWithError)
                ->assertMissing($this->fiberTypeError)
                ->assertSeeIn($this->fiberTypeInput, $muscleRaw['fiber_type'])
                ->assertMissing($this->groupIdFormWithError)
                ->assertMissing($this->groupIdError)
                ->assertPresent($this->getOptionSelectorByValue($muscleRaw['group_id']))
                ->assertMissing($this->heavyMinFormWithError)
                ->assertMissing($this->heavyMinError)
                ->assertInputValue($this->heavyMinInput, $muscleRaw['heavy_min'])
                ->assertMissing($this->heavyMaxFormWithError)
                ->assertMissing($this->heavyMaxError)
                ->assertInputValue($this->heavyMaxInput, $muscleRaw['heavy_max'])
                ->assertMissing($this->lightMinFormWithError)
                ->assertMissing($this->lightMinError)
                ->assertInputValue($this->lightMinInput, $muscleRaw['light_min'])
                ->assertMissing($this->lightMaxFormWithError)
                ->assertMissing($this->lightMaxError)
                ->assertInputValue($this->lightMaxInput, $muscleRaw['light_max'])
                ->assertMissing($this->maxFormWithError)
                ->assertMissing($this->maxError)
                ->assertInputValue($this->maxInput, $muscleRaw['max'])
                ->assertPresent($this->getMuscleRadioSelector($exercise1, $exercise1Intensity))
                ->assertPresent($this->getMuscleRadioSelector($exercise2, $exercise2Intensity))
                ->assertPresent($this->getMuscleRadioSelector($exercise3, $exercise3Intensity))
                ->assertPresent($this->getMuscleRadioSelector($exercise4, $exercise4Intensity));
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_create_page_show_unique_name_error(): void
    {
        Group::factory(10)->create();
        $exercise1 = Exercise::factory()->create();
        $exercise2 = Exercise::factory()->create();
        $exercise3 = Exercise::factory()->create();
        $exercise4 = Exercise::factory()->create();
        $exercise1Intensity = "0.5";
        $exercise2Intensity = "0.0";
        $exercise3Intensity = "1.0";
        $exercise4Intensity = "0.25";
        $muscleRaw = Muscle::factory()->definition();
        Muscle::factory()->create($muscleRaw);

        $this->browse(function (Browser $browser) use ($muscleRaw, $exercise1, $exercise2, $exercise3, $exercise4,
            $exercise1Intensity, $exercise2Intensity, $exercise3Intensity, $exercise4Intensity) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page())
                ->within(new MuscleControllerCreateForm, function (Browser $browser) use($muscleRaw, $exercise1,
                    $exercise2, $exercise3, $exercise4, $exercise1Intensity, $exercise2Intensity, $exercise3Intensity,
                    $exercise4Intensity) {
                    $browser->populate(
                        $muscleRaw['name'],
                        $muscleRaw['fiber_type'],
                        $muscleRaw['group_id'],
                        $muscleRaw['heavy_min'],
                        $muscleRaw['heavy_max'],
                        $muscleRaw['light_min'],
                        $muscleRaw['light_max'],
                        $muscleRaw['max'],
                        $exercise1,
                        $exercise1Intensity,
                        $exercise2,
                        $exercise2Intensity,
                        $exercise3,
                        $exercise3Intensity,
                        $exercise4,
                        $exercise4Intensity,
                    );
                })
                ->scrollIntoView($this->saveButton)
                ->click($this->saveButton)
                ->assertRouteIs('admin.muscle.create')
                ->assertPresent($this->nameFormWithError)
                ->assertSeeIn($this->nameError, 'The name has already been taken.')
                ->assertInputValue($this->nameInput, $muscleRaw['name'])
                ->assertMissing($this->fiberTypeFormWithError)
                ->assertMissing($this->fiberTypeError)
                ->assertSeeIn($this->fiberTypeInput, $muscleRaw['fiber_type'])
                ->assertMissing($this->groupIdFormWithError)
                ->assertMissing($this->groupIdError)
                ->assertPresent($this->getOptionSelectorByValue($muscleRaw['group_id']))
                ->assertMissing($this->heavyMinFormWithError)
                ->assertMissing($this->heavyMinError)
                ->assertInputValue($this->heavyMinInput, $muscleRaw['heavy_min'])
                ->assertMissing($this->heavyMaxFormWithError)
                ->assertMissing($this->heavyMaxError)
                ->assertInputValue($this->heavyMaxInput, $muscleRaw['heavy_max'])
                ->assertMissing($this->lightMinFormWithError)
                ->assertMissing($this->lightMinError)
                ->assertInputValue($this->lightMinInput, $muscleRaw['light_min'])
                ->assertMissing($this->lightMaxFormWithError)
                ->assertMissing($this->lightMaxError)
                ->assertInputValue($this->lightMaxInput, $muscleRaw['light_max'])
                ->assertMissing($this->maxFormWithError)
                ->assertMissing($this->maxError)
                ->assertInputValue($this->maxInput, $muscleRaw['max'])
                ->assertPresent($this->getMuscleRadioSelector($exercise1, $exercise1Intensity))
                ->assertPresent($this->getMuscleRadioSelector($exercise2, $exercise2Intensity))
                ->assertPresent($this->getMuscleRadioSelector($exercise3, $exercise3Intensity))
                ->assertPresent($this->getMuscleRadioSelector($exercise4, $exercise4Intensity));
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_create_page_show_length_name_error(): void
    {
        Group::factory(10)->create();
        $exercise1 = Exercise::factory()->create();
        $exercise2 = Exercise::factory()->create();
        $exercise3 = Exercise::factory()->create();
        $exercise4 = Exercise::factory()->create();
        $exercise1Intensity = "0.5";
        $exercise2Intensity = "0.0";
        $exercise3Intensity = "1.0";
        $exercise4Intensity = "0.25";
        $muscleRaw = Muscle::factory()->definition();
        $muscleRaw['name'] = \Str::random(65);

        $this->browse(function (Browser $browser) use ($muscleRaw, $exercise1, $exercise2, $exercise3, $exercise4,
            $exercise1Intensity, $exercise2Intensity, $exercise3Intensity, $exercise4Intensity) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page())
                ->within(new MuscleControllerCreateForm, function (Browser $browser) use($muscleRaw, $exercise1,
                    $exercise2, $exercise3, $exercise4, $exercise1Intensity, $exercise2Intensity, $exercise3Intensity,
                    $exercise4Intensity) {
                    $browser->populate(
                        $muscleRaw['name'],
                        $muscleRaw['fiber_type'],
                        $muscleRaw['group_id'],
                        $muscleRaw['heavy_min'],
                        $muscleRaw['heavy_max'],
                        $muscleRaw['light_min'],
                        $muscleRaw['light_max'],
                        $muscleRaw['max'],
                        $exercise1,
                        $exercise1Intensity,
                        $exercise2,
                        $exercise2Intensity,
                        $exercise3,
                        $exercise3Intensity,
                        $exercise4,
                        $exercise4Intensity,
                    );
                })
                ->scrollIntoView($this->saveButton)
                ->click($this->saveButton)
                ->assertRouteIs('admin.muscle.create')
                ->assertPresent($this->nameFormWithError)
                ->assertSeeIn($this->nameError, 'The name field must not be greater than 64 characters.')
                ->assertInputValue($this->nameInput, $muscleRaw['name'])
                ->assertMissing($this->fiberTypeFormWithError)
                ->assertMissing($this->fiberTypeError)
                ->assertSeeIn($this->fiberTypeInput, $muscleRaw['fiber_type'])
                ->assertMissing($this->groupIdFormWithError)
                ->assertMissing($this->groupIdError)
                ->assertPresent($this->getOptionSelectorByValue($muscleRaw['group_id']))
                ->assertMissing($this->heavyMinFormWithError)
                ->assertMissing($this->heavyMinError)
                ->assertInputValue($this->heavyMinInput, $muscleRaw['heavy_min'])
                ->assertMissing($this->heavyMaxFormWithError)
                ->assertMissing($this->heavyMaxError)
                ->assertInputValue($this->heavyMaxInput, $muscleRaw['heavy_max'])
                ->assertMissing($this->lightMinFormWithError)
                ->assertMissing($this->lightMinError)
                ->assertInputValue($this->lightMinInput, $muscleRaw['light_min'])
                ->assertMissing($this->lightMaxFormWithError)
                ->assertMissing($this->lightMaxError)
                ->assertInputValue($this->lightMaxInput, $muscleRaw['light_max'])
                ->assertMissing($this->maxFormWithError)
                ->assertMissing($this->maxError)
                ->assertInputValue($this->maxInput, $muscleRaw['max'])
                ->assertPresent($this->getMuscleRadioSelector($exercise1, $exercise1Intensity))
                ->assertPresent($this->getMuscleRadioSelector($exercise2, $exercise2Intensity))
                ->assertPresent($this->getMuscleRadioSelector($exercise3, $exercise3Intensity))
                ->assertPresent($this->getMuscleRadioSelector($exercise4, $exercise4Intensity));
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_create_page_works_with_only_empty_fiber_type(): void
    {
        Group::factory(10)->create();
        $exercise1 = Exercise::factory()->create();
        $exercise2 = Exercise::factory()->create();
        $exercise3 = Exercise::factory()->create();
        $exercise4 = Exercise::factory()->create();
        $exercise1Intensity = "0.5";
        $exercise2Intensity = "0.0";
        $exercise3Intensity = "1.0";
        $exercise4Intensity = "0.25";
        $muscleRaw = Muscle::factory()->definition();
        $muscleRaw['fiber_type'] = '';

        $this->browse(function (Browser $browser) use ($muscleRaw, $exercise1, $exercise2, $exercise3, $exercise4,
            $exercise1Intensity, $exercise2Intensity, $exercise3Intensity, $exercise4Intensity) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page())
                ->within(new MuscleControllerCreateForm, function (Browser $browser) use($muscleRaw, $exercise1,
                    $exercise2, $exercise3, $exercise4, $exercise1Intensity, $exercise2Intensity, $exercise3Intensity,
                    $exercise4Intensity) {
                    $browser->populate(
                        $muscleRaw['name'],
                        $muscleRaw['fiber_type'],
                        $muscleRaw['group_id'],
                        $muscleRaw['heavy_min'],
                        $muscleRaw['heavy_max'],
                        $muscleRaw['light_min'],
                        $muscleRaw['light_max'],
                        $muscleRaw['max'],
                        $exercise1,
                        $exercise1Intensity,
                        $exercise2,
                        $exercise2Intensity,
                        $exercise3,
                        $exercise3Intensity,
                        $exercise4,
                        $exercise4Intensity,
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
        $exercise1 = Exercise::factory()->create();
        $exercise2 = Exercise::factory()->create();
        $exercise3 = Exercise::factory()->create();
        $exercise4 = Exercise::factory()->create();
        $exercise1Intensity = "0.5";
        $exercise2Intensity = "0.0";
        $exercise3Intensity = "1.0";
        $exercise4Intensity = "0.25";
        $muscleRaw = Muscle::factory()->definition();
        $muscleRaw['fiber_type'] = \Str::random(256);

        $this->browse(function (Browser $browser) use ($muscleRaw, $exercise1, $exercise2, $exercise3, $exercise4,
            $exercise1Intensity, $exercise2Intensity, $exercise3Intensity, $exercise4Intensity) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page())
                ->within(new MuscleControllerCreateForm, function (Browser $browser) use($muscleRaw, $exercise1,
                    $exercise2, $exercise3, $exercise4, $exercise1Intensity, $exercise2Intensity, $exercise3Intensity,
                    $exercise4Intensity) {
                    $browser->populate(
                        $muscleRaw['name'],
                        $muscleRaw['fiber_type'],
                        $muscleRaw['group_id'],
                        $muscleRaw['heavy_min'],
                        $muscleRaw['heavy_max'],
                        $muscleRaw['light_min'],
                        $muscleRaw['light_max'],
                        $muscleRaw['max'],
                        $exercise1,
                        $exercise1Intensity,
                        $exercise2,
                        $exercise2Intensity,
                        $exercise3,
                        $exercise3Intensity,
                        $exercise4,
                        $exercise4Intensity,
                    );
                })
                ->scrollIntoView($this->saveButton)
                ->click($this->saveButton)
                ->assertRouteIs('admin.muscle.create')
                ->assertMissing($this->nameFormWithError)
                ->assertMissing($this->nameError)
                ->assertInputValue($this->nameInput, $muscleRaw['name'])
                ->assertPresent($this->fiberTypeFormWithError)
                ->assertSeeIn(
                    $this->fiberTypeError,
                    'The fiber type field must not be greater than 255 characters.'
                )
                ->assertSeeIn($this->fiberTypeInput, $muscleRaw['fiber_type'])
                ->assertMissing($this->groupIdFormWithError)
                ->assertMissing($this->groupIdError)
                ->assertPresent($this->getOptionSelectorByValue($muscleRaw['group_id']))
                ->assertMissing($this->heavyMinFormWithError)
                ->assertMissing($this->heavyMinError)
                ->assertInputValue($this->heavyMinInput, $muscleRaw['heavy_min'])
                ->assertMissing($this->heavyMaxFormWithError)
                ->assertMissing($this->heavyMaxError)
                ->assertInputValue($this->heavyMaxInput, $muscleRaw['heavy_max'])
                ->assertMissing($this->lightMinFormWithError)
                ->assertMissing($this->lightMinError)
                ->assertInputValue($this->lightMinInput, $muscleRaw['light_min'])
                ->assertMissing($this->lightMaxFormWithError)
                ->assertMissing($this->lightMaxError)
                ->assertInputValue($this->lightMaxInput, $muscleRaw['light_max'])
                ->assertMissing($this->maxFormWithError)
                ->assertMissing($this->maxError)
                ->assertInputValue($this->maxInput, $muscleRaw['max'])
                ->assertPresent($this->getMuscleRadioSelector($exercise1, $exercise1Intensity))
                ->assertPresent($this->getMuscleRadioSelector($exercise2, $exercise2Intensity))
                ->assertPresent($this->getMuscleRadioSelector($exercise3, $exercise3Intensity))
                ->assertPresent($this->getMuscleRadioSelector($exercise4, $exercise4Intensity));
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_create_page_show_not_exist_group_id_error(): void
    {
        $group = Group::factory(10)->create();
        $exercise1 = Exercise::factory()->create();
        $exercise2 = Exercise::factory()->create();
        $exercise3 = Exercise::factory()->create();
        $exercise4 = Exercise::factory()->create();
        $exercise1Intensity = "0.5";
        $exercise2Intensity = "0.0";
        $exercise3Intensity = "1.0";
        $exercise4Intensity = "0.25";
        $muscleRaw = Muscle::factory()->definition();
        $muscleRaw['group_id'] = $group->last()->id + 1;

        $this->browse(function (Browser $browser) use ($muscleRaw, $exercise1, $exercise2, $exercise3, $exercise4,
            $exercise1Intensity, $exercise2Intensity, $exercise3Intensity, $exercise4Intensity) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page())
                ->within(new MuscleControllerCreateForm, function (Browser $browser) use($muscleRaw, $exercise1,
                    $exercise2, $exercise3, $exercise4, $exercise1Intensity, $exercise2Intensity, $exercise3Intensity,
                    $exercise4Intensity) {
                    $browser->populate(
                        $muscleRaw['name'],
                        $muscleRaw['fiber_type'],
                        $muscleRaw['group_id'],
                        $muscleRaw['heavy_min'],
                        $muscleRaw['heavy_max'],
                        $muscleRaw['light_min'],
                        $muscleRaw['light_max'],
                        $muscleRaw['max'],
                        $exercise1,
                        $exercise1Intensity,
                        $exercise2,
                        $exercise2Intensity,
                        $exercise3,
                        $exercise3Intensity,
                        $exercise4,
                        $exercise4Intensity,
                    );
                })
                ->value('.group_id-input option[value="null"]', $muscleRaw['group_id'])
                ->scrollIntoView($this->saveButton)
                ->click($this->saveButton)
                ->assertRouteIs('admin.muscle.create')
                ->assertMissing($this->nameFormWithError)
                ->assertMissing($this->nameError)
                ->assertInputValue($this->nameInput, $muscleRaw['name'])
                ->assertMissing($this->fiberTypeFormWithError)
                ->assertMissing($this->fiberTypeError)
                ->assertSeeIn($this->fiberTypeInput, $muscleRaw['fiber_type'])
                ->assertPresent($this->groupIdFormWithError)
                ->assertSeeIn($this->groupIdError, 'The selected group id is invalid.')
                ->assertPresent('.group_id-input option[value="null"]:checked')
                ->assertMissing($this->heavyMinFormWithError)
                ->assertMissing($this->heavyMinError)
                ->assertInputValue($this->heavyMinInput, $muscleRaw['heavy_min'])
                ->assertMissing($this->heavyMaxFormWithError)
                ->assertMissing($this->heavyMaxError)
                ->assertInputValue($this->heavyMaxInput, $muscleRaw['heavy_max'])
                ->assertMissing($this->lightMinFormWithError)
                ->assertMissing($this->lightMinError)
                ->assertInputValue($this->lightMinInput, $muscleRaw['light_min'])
                ->assertMissing($this->lightMaxFormWithError)
                ->assertMissing($this->lightMaxError)
                ->assertInputValue($this->lightMaxInput, $muscleRaw['light_max'])
                ->assertMissing($this->maxFormWithError)
                ->assertMissing($this->maxError)
                ->assertInputValue($this->maxInput, $muscleRaw['max'])
                ->assertPresent($this->getMuscleRadioSelector($exercise1, $exercise1Intensity))
                ->assertPresent($this->getMuscleRadioSelector($exercise2, $exercise2Intensity))
                ->assertPresent($this->getMuscleRadioSelector($exercise3, $exercise3Intensity))
                ->assertPresent($this->getMuscleRadioSelector($exercise4, $exercise4Intensity));
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_create_page_works_with_only_empty_group_id(): void
    {
        Group::factory(10)->create();
        $exercise1 = Exercise::factory()->create();
        $exercise2 = Exercise::factory()->create();
        $exercise3 = Exercise::factory()->create();
        $exercise4 = Exercise::factory()->create();
        $exercise1Intensity = "0.5";
        $exercise2Intensity = "0.0";
        $exercise3Intensity = "1.0";
        $exercise4Intensity = "0.25";
        $muscleRaw = Muscle::factory()->definition();
        $muscleRaw['group_id'] = 'null';

        $this->browse(function (Browser $browser) use ($muscleRaw, $exercise1, $exercise2, $exercise3, $exercise4,
            $exercise1Intensity, $exercise2Intensity, $exercise3Intensity, $exercise4Intensity) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page())
                ->within(new MuscleControllerCreateForm, function (Browser $browser) use($muscleRaw, $exercise1,
                    $exercise2, $exercise3, $exercise4, $exercise1Intensity, $exercise2Intensity, $exercise3Intensity,
                    $exercise4Intensity) {
                    $browser->populate(
                        $muscleRaw['name'],
                        $muscleRaw['fiber_type'],
                        $muscleRaw['group_id'],
                        $muscleRaw['heavy_min'],
                        $muscleRaw['heavy_max'],
                        $muscleRaw['light_min'],
                        $muscleRaw['light_max'],
                        $muscleRaw['max'],
                        $exercise1,
                        $exercise1Intensity,
                        $exercise2,
                        $exercise2Intensity,
                        $exercise3,
                        $exercise3Intensity,
                        $exercise4,
                        $exercise4Intensity,
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
    public function test_the_admin_muscle_create_page_show_error_for_min_heavy_greater_than_max_heavy_if_exit(): void
    {
        Group::factory(10)->create();
        $exercise1 = Exercise::factory()->create();
        $exercise2 = Exercise::factory()->create();
        $exercise3 = Exercise::factory()->create();
        $exercise4 = Exercise::factory()->create();
        $exercise1Intensity = "0.5";
        $exercise2Intensity = "0.0";
        $exercise3Intensity = "1.0";
        $exercise4Intensity = "0.25";
        $muscleRaw = Muscle::factory()->definition();
        $muscleRaw['heavy_max'] = fake()->numberBetween(1, $muscleRaw['max']);
        $muscleRaw['heavy_min'] = fake()->numberBetween($muscleRaw['heavy_max'] + 1, $muscleRaw['max']);

        $this->browse(function (Browser $browser) use ($muscleRaw, $exercise1, $exercise2, $exercise3, $exercise4,
            $exercise1Intensity, $exercise2Intensity, $exercise3Intensity, $exercise4Intensity) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page())
                ->within(new MuscleControllerCreateForm, function (Browser $browser) use($muscleRaw, $exercise1,
                    $exercise2, $exercise3, $exercise4, $exercise1Intensity, $exercise2Intensity, $exercise3Intensity,
                    $exercise4Intensity) {
                    $browser->populate(
                        $muscleRaw['name'],
                        $muscleRaw['fiber_type'],
                        $muscleRaw['group_id'],
                        $muscleRaw['heavy_min'],
                        $muscleRaw['heavy_max'],
                        $muscleRaw['light_min'],
                        $muscleRaw['light_max'],
                        $muscleRaw['max'],
                        $exercise1,
                        $exercise1Intensity,
                        $exercise2,
                        $exercise2Intensity,
                        $exercise3,
                        $exercise3Intensity,
                        $exercise4,
                        $exercise4Intensity,
                    );
                })
                ->scrollIntoView($this->saveButton)
                ->click($this->saveButton)
                ->assertRouteIs('admin.muscle.create')
                ->assertMissing($this->nameFormWithError)
                ->assertMissing($this->nameError)
                ->assertInputValue($this->nameInput, $muscleRaw['name'])
                ->assertMissing($this->fiberTypeFormWithError)
                ->assertMissing($this->fiberTypeError)
                ->assertSeeIn($this->fiberTypeInput, $muscleRaw['fiber_type'])
                ->assertMissing($this->groupIdFormWithError)
                ->assertMissing($this->groupIdError)
                ->assertPresent($this->getOptionSelectorByValue($muscleRaw['group_id']))
                ->assertPresent($this->heavyMinFormWithError)
                ->assertSeeIn(
                    $this->heavyMinError,
                    'The heavy min field must not be greater than ' . $muscleRaw['heavy_max'] . '.'
                )
                ->assertInputValue($this->heavyMinInput, $muscleRaw['heavy_min'])
                ->assertMissing($this->heavyMaxFormWithError)
                ->assertMissing($this->heavyMaxError)
                ->assertInputValue($this->heavyMaxInput, $muscleRaw['heavy_max'])
                ->assertMissing($this->lightMinFormWithError)
                ->assertMissing($this->lightMinError)
                ->assertInputValue($this->lightMinInput, $muscleRaw['light_min'])
                ->assertMissing($this->lightMaxFormWithError)
                ->assertMissing($this->lightMaxError)
                ->assertInputValue($this->lightMaxInput, $muscleRaw['light_max'])
                ->assertMissing($this->maxFormWithError)
                ->assertMissing($this->maxError)
                ->assertInputValue($this->maxInput, $muscleRaw['max'])
                ->assertPresent($this->getMuscleRadioSelector($exercise1, $exercise1Intensity))
                ->assertPresent($this->getMuscleRadioSelector($exercise2, $exercise2Intensity))
                ->assertPresent($this->getMuscleRadioSelector($exercise3, $exercise3Intensity))
                ->assertPresent($this->getMuscleRadioSelector($exercise4, $exercise4Intensity));
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_create_page_show_error_for_min_heavy_greater_than_max_if_exit(): void
    {
        Group::factory(10)->create();
        $exercise1 = Exercise::factory()->create();
        $exercise2 = Exercise::factory()->create();
        $exercise3 = Exercise::factory()->create();
        $exercise4 = Exercise::factory()->create();
        $exercise1Intensity = "0.5";
        $exercise2Intensity = "0.0";
        $exercise3Intensity = "1.0";
        $exercise4Intensity = "0.25";
        $muscleRaw = Muscle::factory()->definition();
        $muscleRaw['max'] = fake()->numberBetween(26, 30);
        $muscleRaw['heavy_max'] = $muscleRaw['max'];
        $muscleRaw['heavy_min'] = $muscleRaw['max'] + fake()->numberBetween(1, 5);

        $this->browse(function (Browser $browser) use ($muscleRaw, $exercise1, $exercise2, $exercise3, $exercise4,
            $exercise1Intensity, $exercise2Intensity, $exercise3Intensity, $exercise4Intensity) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page())
                ->within(new MuscleControllerCreateForm, function (Browser $browser) use($muscleRaw, $exercise1,
                    $exercise2, $exercise3, $exercise4, $exercise1Intensity, $exercise2Intensity, $exercise3Intensity,
                    $exercise4Intensity) {
                    $browser->populate(
                        $muscleRaw['name'],
                        $muscleRaw['fiber_type'],
                        $muscleRaw['group_id'],
                        $muscleRaw['heavy_min'],
                        $muscleRaw['heavy_max'],
                        $muscleRaw['light_min'],
                        $muscleRaw['light_max'],
                        $muscleRaw['max'],
                        $exercise1,
                        $exercise1Intensity,
                        $exercise2,
                        $exercise2Intensity,
                        $exercise3,
                        $exercise3Intensity,
                        $exercise4,
                        $exercise4Intensity,
                    );
                })
                ->scrollIntoView($this->saveButton)
                ->click($this->saveButton)
                ->assertRouteIs('admin.muscle.create')
                ->assertMissing($this->nameFormWithError)
                ->assertMissing($this->nameError)
                ->assertInputValue($this->nameInput, $muscleRaw['name'])
                ->assertMissing($this->fiberTypeFormWithError)
                ->assertMissing($this->fiberTypeError)
                ->assertSeeIn($this->fiberTypeInput, $muscleRaw['fiber_type'])
                ->assertMissing($this->groupIdFormWithError)
                ->assertMissing($this->groupIdError)
                ->assertPresent($this->getOptionSelectorByValue($muscleRaw['group_id']))
                ->assertPresent($this->heavyMinFormWithError)
                ->assertSeeIn(
                    $this->heavyMinError,
                    'The heavy min field must not be greater than ' . $muscleRaw['max'] . '.'
                )
                ->assertInputValue($this->heavyMinInput, $muscleRaw['heavy_min'])
                ->assertMissing($this->heavyMaxFormWithError)
                ->assertMissing($this->heavyMaxError)
                ->assertInputValue($this->heavyMaxInput, $muscleRaw['heavy_max'])
                ->assertMissing($this->lightMinFormWithError)
                ->assertMissing($this->lightMinError)
                ->assertInputValue($this->lightMinInput, $muscleRaw['light_min'])
                ->assertMissing($this->lightMaxFormWithError)
                ->assertMissing($this->lightMaxError)
                ->assertInputValue($this->lightMaxInput, $muscleRaw['light_max'])
                ->assertMissing($this->maxFormWithError)
                ->assertMissing($this->maxError)
                ->assertInputValue($this->maxInput, $muscleRaw['max'])
                ->assertPresent($this->getMuscleRadioSelector($exercise1, $exercise1Intensity))
                ->assertPresent($this->getMuscleRadioSelector($exercise2, $exercise2Intensity))
                ->assertPresent($this->getMuscleRadioSelector($exercise3, $exercise3Intensity))
                ->assertPresent($this->getMuscleRadioSelector($exercise4, $exercise4Intensity));
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_create_page_show_error_for_min_heavy_if_lower_than_one(): void
    {
        Group::factory(10)->create();
        $exercise1 = Exercise::factory()->create();
        $exercise2 = Exercise::factory()->create();
        $exercise3 = Exercise::factory()->create();
        $exercise4 = Exercise::factory()->create();
        $exercise1Intensity = "0.5";
        $exercise2Intensity = "0.0";
        $exercise3Intensity = "1.0";
        $exercise4Intensity = "0.25";
        $muscleRaw = Muscle::factory()->definition();
        $muscleRaw['heavy_min'] = 0;

        $this->browse(function (Browser $browser) use ($muscleRaw, $exercise1, $exercise2, $exercise3, $exercise4,
            $exercise1Intensity, $exercise2Intensity, $exercise3Intensity, $exercise4Intensity) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page())
                ->within(new MuscleControllerCreateForm, function (Browser $browser) use($muscleRaw, $exercise1,
                    $exercise2, $exercise3, $exercise4, $exercise1Intensity, $exercise2Intensity, $exercise3Intensity,
                    $exercise4Intensity) {
                    $browser->populate(
                        $muscleRaw['name'],
                        $muscleRaw['fiber_type'],
                        $muscleRaw['group_id'],
                        $muscleRaw['heavy_min'],
                        $muscleRaw['heavy_max'],
                        $muscleRaw['light_min'],
                        $muscleRaw['light_max'],
                        $muscleRaw['max'],
                        $exercise1,
                        $exercise1Intensity,
                        $exercise2,
                        $exercise2Intensity,
                        $exercise3,
                        $exercise3Intensity,
                        $exercise4,
                        $exercise4Intensity,
                    );
                })
                ->scrollIntoView($this->saveButton)
                ->click($this->saveButton)
                ->assertRouteIs('admin.muscle.create')
                ->assertMissing($this->nameFormWithError)
                ->assertMissing($this->nameError)
                ->assertInputValue($this->nameInput, $muscleRaw['name'])
                ->assertMissing($this->fiberTypeFormWithError)
                ->assertMissing($this->fiberTypeError)
                ->assertSeeIn($this->fiberTypeInput, $muscleRaw['fiber_type'])
                ->assertMissing($this->groupIdFormWithError)
                ->assertMissing($this->groupIdError)
                ->assertPresent($this->getOptionSelectorByValue($muscleRaw['group_id']))
                ->assertPresent($this->heavyMinFormWithError)
                ->assertSeeIn($this->heavyMinError, 'The heavy min field must be at least 1.')
                ->assertInputValue($this->heavyMinInput, $muscleRaw['heavy_min'])
                ->assertMissing($this->heavyMaxFormWithError)
                ->assertMissing($this->heavyMaxError)
                ->assertInputValue($this->heavyMaxInput, $muscleRaw['heavy_max'])
                ->assertMissing($this->lightMinFormWithError)
                ->assertMissing($this->lightMinError)
                ->assertInputValue($this->lightMinInput, $muscleRaw['light_min'])
                ->assertMissing($this->lightMaxFormWithError)
                ->assertMissing($this->lightMaxError)
                ->assertInputValue($this->lightMaxInput, $muscleRaw['light_max'])
                ->assertMissing($this->maxFormWithError)
                ->assertMissing($this->maxError)
                ->assertInputValue($this->maxInput, $muscleRaw['max'])
                ->assertPresent($this->getMuscleRadioSelector($exercise1, $exercise1Intensity))
                ->assertPresent($this->getMuscleRadioSelector($exercise2, $exercise2Intensity))
                ->assertPresent($this->getMuscleRadioSelector($exercise3, $exercise3Intensity))
                ->assertPresent($this->getMuscleRadioSelector($exercise4, $exercise4Intensity));
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_create_page_works_with_min_max_heavy_empty(): void
    {
        Group::factory(10)->create();
        $exercise1 = Exercise::factory()->create();
        $exercise2 = Exercise::factory()->create();
        $exercise3 = Exercise::factory()->create();
        $exercise4 = Exercise::factory()->create();
        $exercise1Intensity = "0.5";
        $exercise2Intensity = "0.0";
        $exercise3Intensity = "1.0";
        $exercise4Intensity = "0.25";
        $muscleRaw = Muscle::factory()->definition();
        $muscleRaw['heavy_min'] = '';
        $muscleRaw['heavy_max'] = '';

        $this->browse(function (Browser $browser) use ($muscleRaw, $exercise1, $exercise2, $exercise3, $exercise4,
            $exercise1Intensity, $exercise2Intensity, $exercise3Intensity, $exercise4Intensity) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page())
                ->within(new MuscleControllerCreateForm, function (Browser $browser) use($muscleRaw, $exercise1,
                    $exercise2, $exercise3, $exercise4, $exercise1Intensity, $exercise2Intensity, $exercise3Intensity,
                    $exercise4Intensity) {
                    $browser->populate(
                        $muscleRaw['name'],
                        $muscleRaw['fiber_type'],
                        $muscleRaw['group_id'],
                        $muscleRaw['heavy_min'],
                        $muscleRaw['heavy_max'],
                        $muscleRaw['light_min'],
                        $muscleRaw['light_max'],
                        $muscleRaw['max'],
                        $exercise1,
                        $exercise1Intensity,
                        $exercise2,
                        $exercise2Intensity,
                        $exercise3,
                        $exercise3Intensity,
                        $exercise4,
                        $exercise4Intensity,
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
