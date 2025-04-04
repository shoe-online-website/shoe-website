<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class SizesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['size_number' => 35, 'created_at' => Carbon::now()],
            ['size_number' => 35.5, 'created_at' => Carbon::now()],
            ['size_number' => 36, 'created_at' => Carbon::now()],
            ['size_number' => 36.5, 'created_at' => Carbon::now()],
            ['size_number' => 37, 'created_at' => Carbon::now()],
            ['size_number' => 37.5, 'created_at' => Carbon::now()],
            ['size_number' => 38, 'created_at' => Carbon::now()],
            ['size_number' => 38.5, 'created_at' => Carbon::now()],
            ['size_number' => 39, 'created_at' => Carbon::now()],
            ['size_number' => 39.5, 'created_at' => Carbon::now()],
            ['size_number' => 40, 'created_at' => Carbon::now()],
            ['size_number' => 40.5, 'created_at' => Carbon::now()],
            ['size_number' => 41, 'created_at' => Carbon::now()],
            ['size_number' => 41.5, 'created_at' => Carbon::now()],
            ['size_number' => 42, 'created_at' => Carbon::now()],
            ['size_number' => 42.5, 'created_at' => Carbon::now()],
            ['size_number' => 43, 'created_at' => Carbon::now()],
            ['size_number' => 43.5, 'created_at' => Carbon::now()],
            ['size_number' => 44, 'created_at' => Carbon::now()],
            ['size_number' => 44.5, 'created_at' => Carbon::now()],
            ['size_number' => 45, 'created_at' => Carbon::now()],
            ['size_number' => 45.5, 'created_at' => Carbon::now()],
            ['size_number' => 46, 'created_at' => Carbon::now()],
            ['size_number' => 46.5, 'created_at' => Carbon::now()],
            ['size_number' => 47, 'created_at' => Carbon::now()],
            ['size_number' => 47.5, 'created_at' => Carbon::now()],
            ['size_number' => 48, 'created_at' => Carbon::now()],
            ['size_number' => 48.5, 'created_at' => Carbon::now()],
            ['size_number' => 49, 'created_at' => Carbon::now()],
            ['size_number' => 49.5, 'created_at' => Carbon::now()],
            ['size_number' => 50, 'created_at' => Carbon::now()],
        ];
        DB::table('sizes')->insert($data);
    }
}
