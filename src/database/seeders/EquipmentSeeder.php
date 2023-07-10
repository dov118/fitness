<?php

namespace Database\Seeders;

use App\Models\Equipment;
use Illuminate\Database\Seeder;

class EquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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

        foreach (['EMPTY', 'EZ', 'BARRE'] as $empty) {
            $EMPTY = $empty === 'EMPTY' ? 1 : 0;
            $EZ = $empty === 'EZ' ? 1 : 0;
            $BARRE = $empty === 'BARRE' ? 1 : 0;

            $i1_25 = 0;
            $i2_5 = 0;
            $i5 = 0;

            for ($i0_5 = 0; $i0_5 < (int)(constant('App\Models\Equipment::_0_5_COUNT')) + 1; $i0_5++) {
                $total0_5 = (float)(constant('App\Models\Equipment::_0_5_WEIGHT')) * ($i0_5*2);
                $total = (float)constant('App\Models\Equipment::'.$empty.'_WEIGHT') + ($total0_5);

                $name = $total . 'kg';
                if ($EMPTY !== 1) {
                    $name .= $EZ === 1 ? ' Ez' : ' Barre';
                }

                $equipments[$name] = [
                    'name' => $name,
                    'weight' => $total,
                    'full2_5' => 0,
                    'full5' => 0,
                    'full7_5' => 0,
                    'empty' => $EMPTY,
                    'ez' => $EZ,
                    'barre' => $BARRE,
                    '0_5' => $i0_5,
                    '1_25' => $i1_25,
                    '2_5' => $i2_5,
                    '5_0' => $i5,
                ];

                for ($i1_25 = 0; $i1_25 < (int)(constant('App\Models\Equipment::_1_25_COUNT')) + 1; $i1_25++) {
                    $total1_25 = (float)(constant('App\Models\Equipment::_1_25_WEIGHT')) * ($i1_25*2) + $total0_5;
                    $total = (float)constant('App\Models\Equipment::'.$empty.'_WEIGHT') + ($total1_25);

                    $name = $total . 'kg';
                    if ($EMPTY !== 1) {
                        $name .= $EZ === 1 ? ' Ez' : ' Barre';
                    }

                    $equipments[$name] = [
                        'name' => $name,
                        'weight' => $total,
                        'full2_5' => 0,
                        'full5' => 0,
                        'full7_5' => 0,
                        'empty' => $EMPTY,
                        'ez' => $EZ,
                        'barre' => $BARRE,
                        '0_5' => $i0_5,
                        '1_25' => $i1_25,
                        '2_5' => $i2_5,
                        '5_0' => $i5,
                    ];

                    for ($i2_5 = 0; $i2_5 < (int)(constant('App\Models\Equipment::_2_5_COUNT')) + 1; $i2_5++) {
                        $total2_5 = (float)(constant('App\Models\Equipment::_2_5_WEIGHT'))
                            * ($i2_5*2) + $total0_5 + $total1_25;
                        $total = (float)constant('App\Models\Equipment::'.$empty.'_WEIGHT') + ($total2_5);

                        $name = $total . 'kg';
                        if ($EMPTY !== 1) {
                            $name .= $EZ === 1 ? ' Ez' : ' Barre';
                        }

                        $equipments[$name] = [
                            'name' => $name,
                            'weight' => $total,
                            'full2_5' => 0,
                            'full5' => 0,
                            'full7_5' => 0,
                            'empty' => $EMPTY,
                            'ez' => $EZ,
                            'barre' => $BARRE,
                            '0_5' => $i0_5,
                            '1_25' => $i1_25,
                            '2_5' => $i2_5,
                            '5_0' => $i5,
                        ];

                        for ($i5 = 0; $i5 < (int)(constant('App\Models\Equipment::_5_COUNT')) + 1; $i5++) {
                            $total5 = (float)(constant('App\Models\Equipment::_5_WEIGHT'))
                                * ($i5*2) + $total0_5 + $total1_25 + $total2_5;
                            $total = (float)constant('App\Models\Equipment::'.$empty.'_WEIGHT') + ($total5);

                            $name = $total . 'kg';
                            if ($EMPTY !== 1) {
                                $name .= $EZ === 1 ? ' Ez' : ' Barre';
                            }

                            $equipments[$name] = [
                                'name' => $name,
                                'weight' => $total,
                                'full2_5' => 0,
                                'full5' => 0,
                                'full7_5' => 0,
                                'empty' => $EMPTY,
                                'ez' => $EZ,
                                'barre' => $BARRE,
                                '0_5' => $i0_5,
                                '1_25' => $i1_25,
                                '2_5' => $i2_5,
                                '5_0' => $i5,
                            ];
                        }
                    }
                }
            }
        }

        foreach ($equipments as $equipment) {
            Equipment::factory()->create($equipment);
        }
    }
}
