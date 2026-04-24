<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RestaurantTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Restaurant::create([
            'name' => 'مطعم KFC',
             'city_id' => 1,
            'user_id'=>4,
        ]);
    }
}
