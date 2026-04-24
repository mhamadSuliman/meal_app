<?php

namespace Database\Seeders;

use App\Models\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         {
        // ================= ADMIN =================
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@meals.app',
            'phone' => '0999000001',
            'password' => Hash::make('123456789'),
            'city_id' => 1,
            'type' => 'admin',
            'is_active' => true,
            'points' => 0,
        ]);

        // ================= NORMAL USERS =================
        User::create([
            'name' => 'Normal User 1',
            'email' => 'user1@meals.app',
            'phone' => '0999000002',
            'password' => Hash::make('123456789'),
            'city_id' => 1,
            'type' => 'user',
            'is_active' => true,
            'points' => 50,
        ]);

        User::create([
            'name' => 'Normal User 2',
            'email' => 'user2@meals.app',
            'phone' => '0999000003',
            'password' => Hash::make('123456789'),
            'city_id' => 2,
            'type' => 'user',
            'is_active' => true,
            'points' => 120,
        ]);

        // ================= RESTAURANT OWNERS =================
        User::create([
            'name' => 'Restaurant Owner 1',
            'email' => 'owner1@meals.app',
            'phone' => '0999000004',
            'password' => Hash::make('123456789'),
            'city_id' => 2,
            'type' => 'restaurant_owner',
            'is_active' => true,
            'points' => 0,
        ]);

        User::create([
            'name' => 'Restaurant Owner 2',
            'email' => 'owner2@meals.app',
            'phone' => '0999000005',
            'password' => Hash::make('123456789'),
            'city_id' => 2,
            'type' => 'restaurant_owner',
            'is_active' => true,
            'points' => 0,
        ]);
    }
    }
}
