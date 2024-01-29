<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Indicates whether the default seeder should run before each test.
     *
     * @var bool
     */
    protected $seed = true;

    /**
     * A basic feature test example.
     */
    public function test_the_database_seeder_works(): void
    {
        $this->assertTrue(true);
    }
}
