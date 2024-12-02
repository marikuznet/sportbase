<?php

namespace Database\Seeders;

use App\Models\Tender\AdditionTender;
use Illuminate\Database\Seeder;

class AdditionTenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $addition = [
            ['title' => 'Трансферы'],
            ['title' => 'Экскурсионная программа'],
            ['title' => 'Развлекательная программа'],
        ];
        foreach ($addition as $item) {
            AdditionTender::create($item);
        }
    }
}
