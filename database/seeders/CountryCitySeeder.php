<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountryCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
{
    $data = [
        'syria' => ['Damascus', 'Aleppo'],
        'lebanon' => ['Beirut'],
        'uae' => ['Dubai', 'Abu Dhabi'],
        'ksa' => ['Riyadh'],
        'irq' => ['Baghdad']
    ];

    foreach ($data as $countryName => $cities) {

        $country = Country::create([
            'name' => $countryName
        ]);

        foreach ($cities as $city) {
            City::create([
                'name' => $city,
                'country_id' => $country->id
            ]);
        }
    }
}
}
