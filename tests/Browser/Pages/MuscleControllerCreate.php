<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class MuscleControllerCreate extends Page
{
    /**
     * Get the URL for the page.
     */
    public function url(): string
    {
        return route('admin.muscle.create', [], false);
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
            '@name-form' => '.name-form',
            '@name-form-with-error' => '.name-form.errored',
            '@name-input' => '.name-input',
            '@name-error' => '.name-error',

            '@fiber_type-form' => '.fiber_type-form',
            '@fiber_type-form-with-error' => '.fiber_type-form.errored',
            '@fiber_type-input' => '.fiber_type-input',
            '@fiber_type-error' => '.fiber_type-error',

            '@group_id-form' => '.group_id-form',
            '@group_id-form-with-error' => '.group_id-form.errored',
            '@group_id-input' => '.group_id-input',
            '@group_id-error' => '.group_id-error',

            '@heavy_min-form' => '.heavy_min-form',
            '@heavy_min-form-with-error' => '.heavy_min-form.errored',
            '@heavy_min-input' => '.heavy_min-input',
            '@heavy_min-error' => '.heavy_min-error',

            '@heavy_max-form' => '.heavy_max-form',
            '@heavy_max-form-with-error' => '.heavy_max-form.errored',
            '@heavy_max-input' => '.heavy_max-input',
            '@heavy_max-error' => '.heavy_max-error',

            '@light_min-form' => '.light_min-form',
            '@light_min-form-with-error' => '.light_min-form.errored',
            '@light_min-input' => '.light_min-input',
            '@light_min-error' => '.light_min-error',

            '@light_max-form' => '.light_max-form',
            '@light_max-form-with-error' => '.light_max-form.errored',
            '@light_max-input' => '.light_max-input',
            '@light_max-error' => '.light_max-error',

            '@max-form' => '.max-form',
            '@max-form-with-error' => '.max-form.errored',
            '@max-input' => '.max-input',
            '@max-error' => '.max-error',

            '@save-button' => '.save-button',
        ];
    }
}
