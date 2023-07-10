<?php

namespace Database\Seeders;

use App\Models\Period;
use Carbon\CarbonInterface;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class PeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        for ($week = 1; $week < 53; $week++) {
            Period::factory()->create([
                'name' => 'S'.$week,
                'start' => now()->startOfWeek(CarbonInterface::MONDAY)->week($week),
                'stop' => now()->startOfWeek(CarbonInterface::MONDAY)->week($week)->add('days', 5),
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
