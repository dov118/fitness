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

            $i125 = 0;
            $i25 = 0;
            $i5 = 0;

            for ($i05 = 0; $i05 < (int)(constant('App\Models\Equipment::EQUIPMENT_0_5_COUNT')) + 1; $i05++) {
                $total05 = (float)(constant('App\Models\Equipment::EQUIPMENT_0_5_WEIGHT'))
                    * ($i05*2);
                $total = (float)constant('App\Models\Equipment::'.$item.'_WEIGHT') + ($total05);

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
                    '5_0' => $i5,
                ];

                for ($i125 = 0; $i125 < (int)(constant('App\Models\Equipment::EQUIPMENT_1_25_COUNT')) + 1; $i125++) {
                    $total125 = (float)(constant('App\Models\Equipment::EQUIPMENT_1_25_WEIGHT'))
                        * ($i125*2) + $total05;
                    $total = (float)constant('App\Models\Equipment::'.$item.'_WEIGHT') + ($total125);

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
                        '5_0' => $i5,
                    ];

                    for ($i25 = 0; $i25 < (int)(constant('App\Models\Equipment::EQUIPMENT_2_5_COUNT')) + 1; $i25++) {
                        $total25 = (float)(constant('App\Models\Equipment::EQUIPMENT_2_5_WEIGHT'))
                            * ($i25*2) + $total05 + $total125;
                        $total = (float)constant('App\Models\Equipment::'.$item.'_WEIGHT') + ($total25);

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
                            '5_0' => $i5,
                        ];

                        for ($i5 = 0; $i5 < (int)(constant('App\Models\Equipment::EQUIPMENT_5_COUNT')) + 1; $i5++) {
                            $total5 = (float)(constant('App\Models\Equipment::EQUIPMENT_5_WEIGHT'))
                                * ($i5*2) + $total05 + $total125 + $total25;
                            $total = (float)constant('App\Models\Equipment::'.$item.'_WEIGHT') + ($total5);

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
                                '5_0' => $i5,
                            ];
                        }
                    }
                }
            }
        }

        Schema::disableForeignKeyConstraints();
        foreach ($equipments as $equipment) {
            Equipment::factory()->create($equipment);
        }
        Schema::enableForeignKeyConstraints();
    }
}
