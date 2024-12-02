<?php

namespace Database\Seeders;

use App\Models\AccomodationType;
use Illuminate\Database\Seeder;

class AccomodationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accType = [
            ['title' => 'Общежитие'],
            ['title' => 'Гостиница 4 звезды'],
            ['title' => 'Гостиница 5 звезд'],
        ];

        foreach ($accType as $type) {
            AccomodationType::create($type);
        }
        //AccomodationType::factory()->count(5)->create();
    }
}
