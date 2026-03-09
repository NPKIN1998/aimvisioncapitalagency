<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('properties')->insert([
            [
                'name' => 'Luxury Villa',
                'capital' => 5000.00,
                'daily_rent' => 400.00,
                'total_rent' => 12000.00,
                'days' => 30,
                'upline_bonus' => 150.00,
                'claim_rent' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Modern Apartment',
                'capital' => 10000.00,
                'daily_rent' => 800.00,
                'total_rent' => 24000.00,
                'days' => 30,
                'upline_bonus' => 300.00,
                'claim_rent' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Beach House',
                'capital' => 20000.00,
                'daily_rent' => 1600.00,
                'total_rent' => 48000.00,
                'days' => 30,
                'upline_bonus' => 600.00,
                'claim_rent' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Penthouse',
                'capital' => 50000.00,
                'daily_rent' => 4000.00,
                'total_rent' => 120000.00,
                'days' => 30,
                'upline_bonus' => 1500.00,
                'claim_rent' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Countryside Cottage',
                'capital' => 100000.00,
                'daily_rent' => 8000.00,
                'total_rent' => 320000.00,
                'days' => 40,
                'upline_bonus' => 3000.00,
                'claim_rent' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Suburban Home',
                'capital' => 200000.00,
                'daily_rent' => 200.00,
                'total_rent' => 0.00,
                'days' => 50,
                'upline_bonus' => 2000.00,
                'claim_rent' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
