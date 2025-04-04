<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')
        ->insert([
            ['name' => 'NIKE','slug' => 'nike', 'created_at' => now()],
            ['name' => 'ADIDAS','slug' => 'adidas', 'created_at' => now()],
            ['name' => 'JORDAN','slug' => 'jordan', 'created_at' => now()],
            ['name' => 'YEEZY','slug' => 'yeezy', 'created_at' => now()]
        ]);
    }
}
