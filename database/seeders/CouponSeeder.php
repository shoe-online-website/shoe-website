<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($index = 1; $index <= 5; $index++) {
            $coupon = new Coupon();
            $coupon->code = createCoupon();
            $coupon->discount_type = rand(0, 1) ? 'percent' : 'value';
            if($coupon->discount_type == 'percent') {
                $coupon->discount_value = rand(10, 40);
            }
            $coupon->save();
        }
    }
}
