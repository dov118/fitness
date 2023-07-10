<?php

namespace Tests\Feature;

use App\Models\Exercise;
use App\Models\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FileTest extends TestCase
{
    use RefreshDatabase;

    protected Model $exercise;
    protected Model $file;
    protected Model $result;

    public function setUp(): void
    {
        parent::setUp();

        // Create fake exercise
        $this->exercise = Exercise::factory()->create();

        // Create fake file
        $this->file = File::factory()->hasAttached($this->exercise)->create();

        // Update models
        $this->result = File::with('exercises')->find($this->file->id);
    }

    public function test_the_exercises_relation_works()
    {
        foreach ($this->result->exercises as $item) {
            $this->assertTrue($item->id === $this->exercise->id);
        }
    }
}
