<?php

namespace Tests\Feature;

use App\Models\Exercise;
use App\Models\File;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FileTest extends TestCase
{
    use RefreshDatabase;

    public function test_relations_works()
    {
        // Create fake exercise
        $exercise = Exercise::factory()->create();

        // Create fake file
        $file = File::factory()->hasAttached($exercise)->create();

        // Update models
        $result = File::with('exercises')->find($file->id);

        foreach ($result->exercises as $item) {
            $this->assertTrue($item->id === $exercise->id);
        }
    }
}
