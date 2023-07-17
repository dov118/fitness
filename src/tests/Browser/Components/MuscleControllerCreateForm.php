<?php

namespace Tests\Browser\Components;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Component as BaseComponent;

class MuscleControllerCreateForm extends BaseComponent
{
    /**
     * Get the root selector for the component.
     */
    public function selector(): string
    {
        return '.muscle-create-form';
    }

    /**
     * Assert that the browser page contains the component.
     */
    public function assert(Browser $browser): void
    {
        $browser->assertVisible($this->selector());
    }

    /**
     * Get the element shortcuts for the component.
     *
     * @return array<string, string>
     */
    public function elements(): array
    {
        return [
            '@name-input' => '.name-input',
            '@fiber_type-input' => '.fiber_type-input',
            '@group_id-input' => '.group_id-input',
            '@heavy_min-input' => '.heavy_min-input',
            '@heavy_max-input' => '.heavy_max-input',
            '@light_min-input' => '.light_min-input',
            '@light_max-input' => '.light_max-input',
            '@max-input' => '.max-input',
        ];
    }

    public function populate(Browser $browser, $name, $fiber_type, $group_id, $heavy_min, $heavy_max, $light_min, $light_max, $max): void
    {
        $browser
            ->type('@name-input', $name)
            ->type('@name-input', $name)
            ->type('@fiber_type-input', $fiber_type)
            ->type('@heavy_min-input', $heavy_min)
            ->type('@heavy_max-input', $heavy_max)
            ->type('@light_min-input', $light_min)
            ->type('@light_max-input', $light_max)
            ->type('@max-input', $max)
            ->select('@group_id-input', $group_id);
    }
}
