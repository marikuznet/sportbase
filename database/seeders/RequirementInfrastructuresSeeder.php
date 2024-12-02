<?php

namespace Database\Seeders;

use App\Models\Tender\RequirementInfrastructures;
use Illuminate\Database\Seeder;

class RequirementInfrastructuresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $requirement_infrastructures = [
            ['title' => 'Открытая площадка ОФП'],
            ['title' => 'Крытая площадка ОФП'],
            ['title' => 'Футбольный стадион Fifa'],
            ['title' => 'Искусственное футбольное поле'],
            ['title' => 'Натуральное футбольное поле'],
            ['title' => 'Бассейн'],
            ['title' => 'Беговые дорожки'],
            ['title' => 'Тренажерный зал'],
            ['title' => 'Мини-футбол'],
        ];
        foreach ($requirement_infrastructures as $item) {
            RequirementInfrastructures::create($item);
        }
    }
}
