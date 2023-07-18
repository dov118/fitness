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

    public function populate(
        Browser $browser, $name, $fiberType, $groupId, $heavyMin, $heavyMax, $lightMin, $lightMax, $max, $exercise1,
        $exercise1Intensity, $exercise2, $exercise2Intensity, $exercise3, $exercise3Intensity, $exercise4,
        $exercise4Intensity,
    ): void
    {
        $browser
            ->type('@name-input', $name)
            ->type('@fiber_type-input', $fiberType)
            ->type('@heavy_min-input', $heavyMin)
            ->type('@heavy_max-input', $heavyMax)
            ->type('@light_min-input', $lightMin)
            ->type('@light_max-input', $lightMax)
            ->type('@max-input', $max)
            ->select('@group_id-input', $groupId)
            ->scrollIntoView('.exercise-' . $exercise1->id . '-form')
            ->check('.exercise-' . $exercise1->id . '-form label[data-value="' . $exercise1Intensity . '"]')
            ->scrollIntoView('.exercise-' . $exercise2->id . '-form')
            ->check('.exercise-' . $exercise2->id . '-form label[data-value="' . $exercise2Intensity . '"]')
            ->scrollIntoView('.exercise-' . $exercise3->id . '-form')
            ->check('.exercise-' . $exercise3->id . '-form label[data-value="' . $exercise3Intensity . '"]')
            ->scrollIntoView('.exercise-' . $exercise3->id . '-form')
            ->check('.exercise-' . $exercise4->id . '-form label[data-value="' . $exercise4Intensity . '"]');
    }
}
