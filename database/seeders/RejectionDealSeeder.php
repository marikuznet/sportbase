<?php

namespace Database\Seeders;

use App\Models\Deal\RejectionDeal;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class RejectionDealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rejections = [
            ['title' => 'Не подошла цена'],
            ['title' => 'Не подошли сроки'],
            ['title' => 'Не подошла инфрастурктура'],
            ['title' => 'Исчезла потребность'],
            ['title' => 'Договорился с другим'],
            ['title' => 'Свой вариант'],
        ];
        foreach ($rejections as $item) {
            RejectionDeal::create($item);
        }
    }
}
