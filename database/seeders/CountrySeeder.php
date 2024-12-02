<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use PragmaRX\Countries\Package\Countries;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
          ['title' => 'Россия'],
          ['title' => 'Украина'],
          ['title' => 'Белоруссия'],
          ['title' => 'Германия'],
          ['title' => 'Латвия'],
        ];

        /*$countries = [
            ['title' => 'Футбол',],
            ['title' => 'Хоккей'],
        ];*/
        foreach ($countries as $country) {
            Country::create($country);
        }
        //Country::factory()->count(5)->create();
    }
}
