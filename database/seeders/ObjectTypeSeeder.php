<?php

namespace Database\Seeders;

use App\Models\ObjectType;
use Illuminate\Database\Seeder;

class ObjectTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $objectType = [
            ['title' => 'Стадион',],
            ['title' => 'Спорт база'],
            ['title' => 'Тренировочная база',],
            ['title' => "Отель / пансионат",],
        ];

        foreach ($objectType as $type) {
            ObjectType::create($type);
        }
        /*$hostel = ObjectType::create([
            'title' => 'Общежитие',
        ]);
        $hotelFour = ObjectType::create([
            'title' => 'Гостиница (4зв)',
        ]);
        $hotelFive = ObjectType::create([
            'title' => 'Гостиница (5зв)',
        ]);*/

        //ObjectType::factory()->count(5)->create();
    }
}
