<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        foreach ([
            1 => 'Pectoraux',
            2 => 'Epaules',
            3 => 'Triceps',
            4 => 'Dorsaux',
            5 => 'Biceps',
            6 => 'Jambes',
            7 => 'Mollets',
            8 => 'Abdominaux'
        ] as $id=>$name) {
            Group::factory()->create([
                'id' => $id,
                'name' => $name
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
