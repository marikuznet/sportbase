<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            ['title' => 'Гостиничный корпус',],
            ['title' => 'Рестораны,кафе'],
            ['title' => 'Бильярд',],
            ['title' => "Кинотеатр",],
            ['title' => "Медицинские услуги",],
            ['title' => "Банный комплекс",],
            ['title' => "Анимация для детей и взрослых",],
            ['title' => "Сауны и бани",]
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
        // Service::factory()->count(5)->create();
    }
}
