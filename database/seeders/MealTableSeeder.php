<?php

namespace Database\Seeders;

use App\Models\Meal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MealTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Meal::create([
            'name' => 'بيتزا',
            'description' => 'بيتزا لذيذة مع جبن وطحين طازج',
            'price' => 5,
            'rating' => 4.4,
            'type' => 'غربي',
            'restaurant_id' => 1, // لازم يكون موجود في جدول المطاعم
        ]);
    }
}
