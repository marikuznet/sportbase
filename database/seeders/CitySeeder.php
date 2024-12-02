<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = [
            ['title' => 'Москва', 'region_id' => 5],
            ['title' => 'Краснодар', 'region_id' => 1],
            ['title' => 'Новороссийск', 'region_id' => 1],
            ['title' => 'Белгород', 'region_id' => 2],
            ['title' => 'Самара', 'region_id' => 4],
            ['title' => 'Воронеж', 'region_id' => 3],
            ['title' => 'Ростов-на-Дону', 'region_id' => 6],
        ];
        foreach ($cities as $city) {
            City::create($city);
        }

        //City::factory()->count(5)->create();
    }
}
