<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(FileSeeder::class);
        $this->call(EquipmentSeeder::class);
        $this->call(GroupSeeder::class);
        $this->call(MuscleSeeder::class);
        $this->call(ExerciseSeeder::class);
        $this->call(TypeSeeder::class);
        $this->call(PeriodSeeder::class);
        $this->call(SessionSeeder::class);
        $this->call(SetSeeder::class);
    }
}
