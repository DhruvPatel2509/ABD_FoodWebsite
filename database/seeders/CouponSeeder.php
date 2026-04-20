<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Coupon;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Coupon::create([
            'code' => 'WELCOME20',
            'type' => 'percent',
            'value' => 20, // 20% off
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'ABD50',
            'type' => 'fixed',
            'value' => 50, // ₹50 off
            'is_active' => true,
        ]);
    }
}
