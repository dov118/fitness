<?php

namespace Database\Seeders;

use App\Models\Set;
use Illuminate\Database\Seeder;

class SetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Set::factory(10)->create();
    }
}
