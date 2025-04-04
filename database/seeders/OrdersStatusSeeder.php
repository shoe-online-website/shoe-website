<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Chờ duyệt', 'color' => 'warning', 'is_success' => false], 
            ['name' => 'Đã duyệt' , 'color' => 'success', 'is_success' => true], 
        ];
        DB::table('orders_status')->insert($data);
    }
}
