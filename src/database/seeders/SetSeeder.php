<?php

namespace Database\Seeders;

use App\Models\Set;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class SetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Set::factory(10)->create();
        Schema::enableForeignKeyConstraints();
    }
}
