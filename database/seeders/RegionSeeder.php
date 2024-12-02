<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regions = [
            ['title' => 'Краснодарский край', 'country_id' => 1],
            ['title' => 'Белгородская обл', 'country_id' => 1],
            ['title' => 'Воронежская обл.', 'country_id' => 1],
            ['title' => 'Самарская обл.', 'country_id' => 1],
            ['title' => 'Москва', 'country_id' => 1],
            ['title' => 'Ростовская обл.', 'country_id' => 1],
        ];

        /*$countries = [
            ['title' => 'Футбол',],
            ['title' => 'Хоккей'],
        ];*/
        foreach ($regions as $region) {
            Region::create($region);
        }
        //Region::factory()->count(5)->create();
    }
}
