<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    $user = \App\Models\User::create([
        'name' => 'Delivery 1',
        'email' => 'delivery@test.com',
        'password' => bcrypt('123456'),
        'type' => 'delivery'
    ]);

    \App\Models\DeliveryPerson::create([
        'user_id' => $user->id,
        'is_available' => true,
        'phone' => '0999999999'
    ]);
}
}
