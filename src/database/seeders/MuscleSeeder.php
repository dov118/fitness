<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Muscle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class MuscleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        Muscle::factory()->for(Group::find(6))->create([
            'id' => 1, 'name' => 'Quadriceps',
            'heavy_min' => 1, 'heavy_max' => 1,
            'light_min' => 1, 'light_max' => 1,
            'fiber_type' => 1, 'max' => 1,
        ]);

        Muscle::factory()->for(Group::find(6))->create([
            'id' => 2, 'name' => 'Fessiers',
            'heavy_min' => 1, 'heavy_max' => 1,
            'light_min' => 1, 'light_max' => 1,
            'fiber_type' => 1, 'max' => 1,
        ]);

        Muscle::factory()->for(Group::find(6))->create([
            'id' => 3, 'name' => 'Ischios-jambiers',
            'heavy_min' => 1, 'heavy_max' => 1,
            'light_min' => 1, 'light_max' => 1,
            'fiber_type' => 1, 'max' => 1,
        ]);

        Muscle::factory()->for(Group::find(7))->create([
            'id' => 4, 'name' => 'Gastrocnémien',
            'heavy_min' => 1, 'heavy_max' => 1,
            'light_min' => 1, 'light_max' => 1,
            'fiber_type' => 1, 'max' => 1,
        ]);

        Muscle::factory()->for(Group::find(7))->create([
            'id' => 5, 'name' => 'Soléaire',
            'heavy_min' => 1, 'heavy_max' => 1,
            'light_min' => 1, 'light_max' => 1,
            'fiber_type' => 1, 'max' => 1,
        ]);

        Muscle::factory()->for(Group::find(2))->create([
            'id' => 6, 'name' => 'Faisceau antérieur',
            'heavy_min' => 1, 'heavy_max' => 1,
            'light_min' => 1, 'light_max' => 1,
            'fiber_type' => 1, 'max' => 1,
        ]);

        Muscle::factory()->for(Group::find(2))->create([
            'id' => 7, 'name' => 'Faisceau moyen',
            'heavy_min' => 1, 'heavy_max' => 1,
            'light_min' => 1, 'light_max' => 1,
            'fiber_type' => 1, 'max' => 1,
        ]);

        Muscle::factory()->for(Group::find(2))->create([
            'id' => 8, 'name' => 'Faisceau postérieur',
            'heavy_min' => 1, 'heavy_max' => 1,
            'light_min' => 1, 'light_max' => 1,
            'fiber_type' => 1, 'max' => 1,
        ]);

        Muscle::factory()->for(Group::find(8))->create([
            'id' => 9, 'name' => 'Droit de l\'abdomen (haut)',
            'heavy_min' => 1, 'heavy_max' => 1,
            'light_min' => 1, 'light_max' => 1,
            'fiber_type' => 1, 'max' => 1,
        ]);

        Muscle::factory()->for(Group::find(8))->create([
            'id' => 10, 'name' => 'Droit de l\'abdomen (bas)',
            'heavy_min' => 1, 'heavy_max' => 1,
            'light_min' => 1, 'light_max' => 1,
            'fiber_type' => 1, 'max' => 1,
        ]);

        Muscle::factory()->for(Group::find(8))->create([
            'id' => 11, 'name' => 'Obliques',
            'heavy_min' => 1, 'heavy_max' => 1,
            'light_min' => 1, 'light_max' => 1,
            'fiber_type' => 1, 'max' => 1,
        ]);

        Muscle::factory()->for(Group::find(8))->create([
            'id' => 12, 'name' => 'Transverse',
            'heavy_min' => 1, 'heavy_max' => 1,
            'light_min' => 1, 'light_max' => 1,
            'fiber_type' => 1, 'max' => 1,
        ]);

        Muscle::factory()->for(Group::find(1))->create([
            'id' => 13, 'name' => 'Faisceau claviculaire',
            'heavy_min' => 1, 'heavy_max' => 1,
            'light_min' => 1, 'light_max' => 1,
            'fiber_type' => 1, 'max' => 1,
        ]);

        Muscle::factory()->for(Group::find(1))->create([
            'id' => 14, 'name' => 'Faisceau sterno-costal',
            'heavy_min' => 1, 'heavy_max' => 1,
            'light_min' => 1, 'light_max' => 1,
            'fiber_type' => 1, 'max' => 1,
        ]);

        Muscle::factory()->for(Group::find(4))->create([
            'id' => 15, 'name' => 'Largeur du dos (bas)',
            'heavy_min' => 1, 'heavy_max' => 1,
            'light_min' => 1, 'light_max' => 1,
            'fiber_type' => 1, 'max' => 1,
        ]);

        Muscle::factory()->for(Group::find(4))->create([
            'id' => 16, 'name' => 'Épaisseur du dos (haut)',
            'heavy_min' => 1, 'heavy_max' => 1,
            'light_min' => 1, 'light_max' => 1,
            'fiber_type' => 1, 'max' => 1,
        ]);

        Muscle::factory()->for(Group::find(5))->create([
            'id' => 17, 'name' => 'brachio-radial + radial',
            'heavy_min' => 1, 'heavy_max' => 1,
            'light_min' => 1, 'light_max' => 1,
            'fiber_type' => 1, 'max' => 1,
        ]);

        Muscle::factory()->for(Group::find(5))->create([
            'id' => 18, 'name' => 'court biceps',
            'heavy_min' => 1, 'heavy_max' => 1,
            'light_min' => 1, 'light_max' => 1,
            'fiber_type' => 1, 'max' => 1,
        ]);

        Muscle::factory()->for(Group::find(5))->create([
            'id' => 19, 'name' => 'long biceps',
            'heavy_min' => 1, 'heavy_max' => 1,
            'light_min' => 1, 'light_max' => 1,
            'fiber_type' => 1, 'max' => 1,
        ]);

        Muscle::factory()->for(Group::find(3))->create([
            'id' => 20, 'name' => 'chef latéral',
            'heavy_min' => 1, 'heavy_max' => 1,
            'light_min' => 1, 'light_max' => 1,
            'fiber_type' => 1, 'max' => 1,
        ]);

        Muscle::factory()->for(Group::find(3))->create([
            'id' => 21, 'name' => 'chef long',
            'heavy_min' => 1, 'heavy_max' => 1,
            'light_min' => 1, 'light_max' => 1,
            'fiber_type' => 1, 'max' => 1,
        ]);

        Muscle::factory()->for(Group::find(3))->create([
            'id' => 22, 'name' => 'Chef médial',
            'heavy_min' => 1, 'heavy_max' => 1,
            'light_min' => 1, 'light_max' => 1,
            'fiber_type' => 1, 'max' => 1,
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
