<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Type::factory()->create([
            'id' => 1,
            'name' => 'Push light',
            'light' => true,
            'heavy' => false,
        ]);

        Type::factory()->create([
            'id' => 2,
            'name' => 'Pull light',
            'light' => true,
            'heavy' => false,
        ]);

        Type::factory()->create([
            'id' => 3,
            'name' => 'Legs light',
            'light' => true,
            'heavy' => false,
        ]);

        Type::factory()->create([
            'id' => 4,
            'name' => 'Push heavy',
            'light' => false,
            'heavy' => true,
        ]);

        Type::factory()->create([
            'id' => 5,
            'name' => 'Pull heavy',
            'light' => false,
            'heavy' => true,
        ]);

        Type::factory()->create([
            'id' => 6,
            'name' => 'Legs heavy',
            'light' => false,
            'heavy' => true,
        ]);
    }
}
