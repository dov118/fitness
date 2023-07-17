<?php

namespace Tests\Browser\Pages;

use App\Models\Muscle;
use Laravel\Dusk\Browser;

class MuscleControllerShow extends Page
{
    protected Muscle $muscle;

    public function __construct(Muscle $muscle)
    {
        $this->muscle = $muscle;
    }

    /**
     * Get the URL for the page.
     */
    public function url(): string
    {
        return route('admin.muscle.show', [$this->muscle], false);
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
            '@group-link' => '.group-link',
            '@group-name' => '.group-name',
            '@heavy-min' => '.heavy-min',
            '@heavy-max' => '.heavy-max',
            '@light-min' => '.light-min',
            '@light-max' => '.light-max',
            '@max' => '.max',
            '@fiber-type' => '.fiber-type',
        ];
    }
}
