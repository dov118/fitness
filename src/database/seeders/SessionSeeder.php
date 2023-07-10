<?php

namespace Database\Seeders;

use App\Models\Period;
use App\Models\Session;
use App\Models\Type;
use Carbon\CarbonInterface;
use Illuminate\Database\Seeder;

class SessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ([25, 26] as $week) {
            for ($order = 1; $order < 7; $order++) {
                Session::factory()->for(Type::find($order))->for(Period::find($week))->create([
                    'date' => now()->startOfWeek(CarbonInterface::MONDAY)->week($week)->add('days', $order - 1),
                    'order' => $order,
                ]);
            }
        }
    }
}
