<?php

namespace Database\Seeders;

use App\Models\Tender\TypeFood;
use Illuminate\Database\Seeder;

class TypeFoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $typeFood = [
            ['title' => 'Без питания'],
            ['title' => 'Комплексное'],
            ['title' => 'Шведский стол'],
        ];
        foreach ($typeFood as $item) {
            TypeFood::create($item);
        }
    }
}
