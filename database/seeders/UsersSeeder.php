<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            // [
            //     'name' => 'Admin User',
            //     'email' => 'admin@example.com',
            //     'email_verified_at' => now(),
            //     'password' => Hash::make('password'), // Mã hóa mật khẩu
            //     'is_admin' => true,
            //     'remember_token' => Str::random(10),
            // ],
        ];

        for ($i = 1; $i <= 9; $i++) {
            $users[] = [
                'name' => 'User ' . $i,
                'email' => 'user' . $i . '@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'), // Mã hóa mật khẩu
                'is_admin' => true,
                'remember_token' => Str::random(10),
                'created_at' => now()
            ];
        }

        DB::table('users')->insert($users);
    }
}
