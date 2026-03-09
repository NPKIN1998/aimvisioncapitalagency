<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('packages')->insert([
            [
                'name' => 'Pioneer',
                'initial_capital' => 350,
                'daily_income_percentage' => 0.15,
                'total_returns' => 770,
                'days' => 20,
                'upline_bonus' => 52.5,
                'daily_task' => 1,
            ],
            [
                'name' => 'Explorer',
                'initial_capital' => 700,
                'daily_income_percentage' => 0.15,
                'total_returns' => 1_592.50,
                'days' => 20,
                'upline_bonus' => 105,
                'daily_task' => 1,
            ],
            [
                'name' => 'Momentum',
                'initial_capital' => 1_400,
                'daily_income_percentage' => 0.15,
                'total_returns' => 3_290,
                'days' => 20,
                'upline_bonus' => 210,
                'daily_task' => 1,
            ],
            [
                'name' => 'Elevate',
                'initial_capital' => 2_800,
                'daily_income_percentage' => 0.15,
                'total_returns' => 6_790,
                'days' => 20,
                'upline_bonus' => 420,
                'daily_task' => 1,
            ],
            [
                'name' => 'Legacy',
                'initial_capital' => 5_600,
                'daily_income_percentage' => 0.15,
                'total_returns' => 14_000,
                'days' => 20,
                'upline_bonus' => 840,
                'daily_task' => 1,
            ],
            [
                'name' => 'Prestige',
                'initial_capital' => 11_200,
                'daily_income_percentage' => 0.15,
                'total_returns' => 28_840,
                'days' => 20,
                'upline_bonus' => 1_680,
                'daily_task' => 1,
            ],
            [
                'name' => 'Titan',
                'initial_capital' => 22_400,
                'daily_income_percentage' => 0.15,
                'total_returns' => 59_360,
                'days' => 20,
                'upline_bonus' => 3_360,
                'daily_task' => 1,
            ],
            [
                'name' => 'Summit',
                'initial_capital' => 44_800,
                'daily_income_percentage' => 0.15,
                'total_returns' => 122_080,
                'days' => 20,
                'upline_bonus' => 6_720,
                'daily_task' => 1,
            ],
            [
                'name' => 'Infinity',
                'initial_capital' => 89_600,
                'daily_income_percentage' => 0.15,
                'total_returns' => 250_880,
                'days' => 20,
                'upline_bonus' => 13_440,
                'daily_task' => 1,
            ],
        ]);
    }
}
