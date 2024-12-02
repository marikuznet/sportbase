<?php

namespace Database\Seeders;

use App\Models\Profile\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $positions = [
            ['title' => 'Тренер'],
            ['title' => 'Директор'],
            ['title' => 'Менеджер'],
            ['title' => 'HR'],

        ];
        foreach ($positions as $position) {
            Position::create($position);
        }
    }
}
