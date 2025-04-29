<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vouchers')->insert([
            [
                'logo' => 'vouchers/ga.png',
                'title' => 'Jarir Book Store',
                'voucher_code' => 'JR24B3X7M9',
                'amount' => 200.00,
                'point_cost' => 300,
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'logo' => 'vouchers/Mel.png',
                'title' => 'Half Millon Coffee',
                'voucher_code' => 'HM50C8F2E4',
                'amount' => 50.00,
                'point_cost' => 100,
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'logo' => 'vouchers/Beauty.png',
                'title' => 'Beauty Spa',
                'voucher_code' => 'BT75S3P6A9',
                'amount' => 75.00,
                'point_cost' => 150,
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'logo' => 'vouchers/car.png',
                'title' => 'Car Washer',
                'voucher_code' => 'CW50V2H7R4',
                'amount' => 50.00,
                'point_cost' => 100,
                'is_available' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}