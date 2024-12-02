<?php

namespace Database\Seeders;

use App\Models\SportType;
use Illuminate\Database\Seeder;

class SportTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sportTypes = [
            ['title' => 'Баскетбол',],
            ['title' => 'Борьба'],
            ['title' => 'Велоспорт',],
            ['title' => "Пляжный футбол",],
            ['title' => "Дзюдо",],
            ['title' => "Йога",],
            ['title' => "Карате",],
            ['title' => "Регби",],
            ['title' => "Мини-футбол",],
            ['title' => "Настольный теннис",],
            ['title' => "Спортивная гимнастика",],
            ['title' => "Танцы бальные",],
        ];

        foreach ($sportTypes as $type) {
            SportType::create($type);
        }

        /*$sportTypes = [
            ['title' => 'Футбол',],
            ['title' => 'Хоккей'],
        ];
        foreach ($sportTypes as $type) {
            SportType::create($type);
        }*/
        // SportType::factory()->count(5)->create();
    }
}
