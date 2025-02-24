<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;



class LoginSeeder extends Seeder
{
    public function run()
    {
        DB::table('admins')->updateOrInsert(
            ['email' => 'superadmin@gmail.com'], // Unique key
            [
                'name' => 'Admin',
                'role' => 'superadmin',
                'password' => Hash::make('admin'),
            ]
        );
    }
}
