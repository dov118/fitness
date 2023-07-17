<?php

namespace Database\Seeders;

use App\Models\Equipment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class EquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barreName = ' Barre';
        $equipmentClass = 'App\Models\Equipment::';

        $equipments = [];

        // Haltère 2.5kg
        $equipments[] = [
            'name' => '2.5kg Haltère', 'weight' => 2.5,
            'full2_5' => 1, 'full5' => 0, 'full7_5' => 0,
            'empty' => 0, 'ez' => 0, 'barre' => 0, '0_5' => 0, '1_25' => 0, '2_5' => 0, '5_0' => 0,
        ];

        // Haltère 5kg
        $equipments[] = [
            'name' => '5kg Haltère', 'weight' => 5,
            'full2_5' => 0, 'full5' => 1, 'full7_5' => 0,
            'empty' => 0, 'ez' => 0, 'barre' => 0, '0_5' => 0, '1_25' => 0, '2_5' => 0, '5_0' => 0,
        ];

        // Haltère 7.5kg
        $equipments[] = [
            'name' => '7.5kg Haltère', 'weight' => 7.5,
            'full2_5' => 0, 'full5' => 0, 'full7_5' => 1,
            'empty' => 0, 'ez' => 0, 'barre' => 0, '0_5' => 0, '1_25' => 0, '2_5' => 0, '5_0' => 0,
        ];

        foreach (['EMPTY', 'EZ', 'BARRE'] as $item) {
            $empty = $item === 'EMPTY' ? 1 : 0;
            $ez = $item === 'EZ' ? 1 : 0;
            $barre = $item === 'BARRE' ? 1 : 0;

            $i05 = 0;
            $i125 = 0;
            $i25 = 0;
            $i5 = 0;

            $total05 = 0;
            $total125 = 0;
            $total25 = 0;

            $this->create05Equipments(
                $equipmentClass,
                $total05,
                $total125,
                $total25,
                $item,
                $empty,
                $ez,
                $barre,
                $barreName,
                $i05,
                $i125,
                $i25,
                $i5,
                $equipments
            );
        }

        Schema::disableForeignKeyConstraints();
        foreach ($equipments as $equipment) {
            Equipment::factory()->create($equipment);
        }
        Schema::enableForeignKeyConstraints();
    }

    public function create05Equipments(
        string $equipmentClass,
        float $total05,
        float $total125,
        float $total25,
        string $item,
        string $empty,
        int $ez,
        int $barre,
        string $barreName,
        int $i05,
        int $i125,
        int $i25,
        int $i5,
        array &$equipments
    ): void
    {
        for ($ci05 = 0; $ci05 < (int)(constant($equipmentClass.'EQUIPMENT_0_5_COUNT')) + 1; $ci05++) {
            $ctotal05 = (float)(constant($equipmentClass.'EQUIPMENT_0_5_WEIGHT'))
                * ($ci05*2);
            $total = (float)constant($equipmentClass.$item.'_WEIGHT') + ($ctotal05);

            $name = $total . 'kg';
            if ($empty !== 1) {
                $name .= $ez === 1 ? ' Ez' : $barreName;
            }

            $equipments[$name] = [
                'name' => $name,
                'weight' => $total,
                'full2_5' => 0,
                'full5' => 0,
                'full7_5' => 0,
                'empty' => $empty,
                'ez' => $ez,
                'barre' => $barre,
                '0_5' => $ci05,
                '1_25' => $i125,
                '2_5' => $i25,
                '5_0' => $i5,
            ];

            $this->create125Equipments(
                $equipmentClass,
                $ctotal05,
                $total125,
                $total25,
                $item,
                $empty,
                $ez,
                $barre,
                $barreName,
                $ci05,
                $i125,
                $i25,
                $i5,
                $equipments
            );
        }
    }

    public function create125Equipments(
        string $equipmentClass,
        float $total05,
        float $total125,
        float $total25,
        string $item,
        string $empty,
        int $ez,
        int $barre,
        string $barreName,
        int $i05,
        int $i125,
        int $i25,
        int $i5,
        array &$equipments
    ): void
    {
        for ($ci125 = 0; $ci125 < (int)(constant($equipmentClass.'EQUIPMENT_1_25_COUNT')) + 1; $ci125++) {
            $ctotal125 = (float)(constant($equipmentClass.'EQUIPMENT_1_25_WEIGHT'))
                * ($ci125*2) + $total05;
            $total = (float)constant($equipmentClass.$item.'_WEIGHT') + ($ctotal125);

            $name = $total . 'kg';
            if ($empty !== 1) {
                $name .= $ez === 1 ? ' Ez' : $barreName;
            }

            $equipments[$name] = [
                'name' => $name,
                'weight' => $total,
                'full2_5' => 0,
                'full5' => 0,
                'full7_5' => 0,
                'empty' => $empty,
                'ez' => $ez,
                'barre' => $barre,
                '0_5' => $i05,
                '1_25' => $ci125,
                '2_5' => $i25,
                '5_0' => $i5,
            ];

            $this->create25Equipments(
                $equipmentClass,
                $total05,
                $ctotal125,
                $total25,
                $item,
                $empty,
                $ez,
                $barre,
                $barreName,
                $i05,
                $ci125,
                $i25,
                $i5,
                $equipments
            );
        }
    }

    public function create25Equipments(
        string $equipmentClass,
        float $total05,
        float $total125,
        float $total25,
        string $item,
        string $empty,
        int $ez,
        int $barre,
        string $barreName,
        int $i05,
        int $i125,
        int $i25,
        int $i5,
        array &$equipments
    ): void
    {
        for ($ci25 = 0; $ci25 < (int)(constant($equipmentClass.'EQUIPMENT_2_5_COUNT')) + 1; $ci25++) {
            $ctotal25 = (float)(constant($equipmentClass.'EQUIPMENT_2_5_WEIGHT'))
                * ($ci25*2) + $total05 + $total125;
            $total = (float)constant($equipmentClass.$item.'_WEIGHT') + ($ctotal25);

            $name = $total . 'kg';
            if ($empty !== 1) {
                $name .= $ez === 1 ? ' Ez' : $barreName;
            }

            $equipments[$name] = [
                'name' => $name,
                'weight' => $total,
                'full2_5' => 0,
                'full5' => 0,
                'full7_5' => 0,
                'empty' => $empty,
                'ez' => $ez,
                'barre' => $barre,
                '0_5' => $i05,
                '1_25' => $i125,
                '2_5' => $ci25,
                '5_0' => $i5,
            ];

            $this->create5Equipments(
                $equipmentClass,
                $total05,
                $total125,
                $ctotal25,
                $item,
                $empty,
                $ez,
                $barre,
                $barreName,
                $i05,
                $i125,
                $ci25,
                $i5,
                $equipments
            );
        }
    }

    public function create5Equipments(
        string $equipmentClass,
        float $total05,
        float $total125,
        float $total25,
        string $item,
        string $empty,
        int $ez,
        int $barre,
        string $barreName,
        int $i05,
        int $i125,
        int $i25,
        int $i5,
        array &$equipments
    ): void
    {
        for ($ci5 = 0; $ci5 < (int)(constant($equipmentClass.'EQUIPMENT_5_COUNT')) + 1; $ci5++) {
            $ctotal5 = (float)(constant($equipmentClass.'EQUIPMENT_5_WEIGHT'))
                * ($ci5*2) + $total05 + $total125 + $total25;
            $total = (float)constant($equipmentClass.$item.'_WEIGHT') + ($ctotal5);

            $name = $total . 'kg';
            if ($empty !== 1) {
                $name .= $ez === 1 ? ' Ez' : $barreName;
            }

            $equipments[$name] = [
                'name' => $name,
                'weight' => $total,
                'full2_5' => 0,
                'full5' => 0,
                'full7_5' => 0,
                'empty' => $empty,
                'ez' => $ez,
                'barre' => $barre,
                '0_5' => $i05,
                '1_25' => $i125,
                '2_5' => $i25,
                '5_0' => $ci5,
            ];
        }
    }
}
