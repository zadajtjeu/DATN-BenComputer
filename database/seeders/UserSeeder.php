<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Enums\UserRole;
use App\Enums\UserStatus;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@nam.name.vn',
            'password' => Hash::make('12345678'),
            'phone' => '0971409001',
            'role' => UserRole::ADMIN,
            'status' => UserStatus::ACTIVE,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Manager',
            'email' => 'manager@nam.name.vn',
            'password' => Hash::make('12345678'),
            'phone' => '0123456789',
            'role' => UserRole::MANAGER,
            'status' => UserStatus::ACTIVE,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'User',
            'email' => 'user@nam.name.vn',
            'password' => Hash::make('12345678'),
            'phone' => '0123456787',
            'role' => UserRole::USER,
            'status' => UserStatus::ACTIVE,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'User Baned',
            'email' => 'user2@nam.name.vn',
            'password' => Hash::make('12345678'),
            'phone' => '0123456787',
            'role' => UserRole::USER,
            'status' => UserStatus::BANNED,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
