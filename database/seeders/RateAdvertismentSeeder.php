<?php

namespace Database\Seeders;

use App\Models\Advertisment\RateAdvertisment;
use Illuminate\Database\Seeder;

class RateAdvertismentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rates = [
            ['title' => 'Продвижение в каталоге', 'description' => 'Lorem ipsum dolor sit amet,consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar sic tempor. Sociis natoque penatibus et magnis dis parturient montes',
                'price' => [['days' => 7, 'oneDay' => 1000, 'allPrice' => 10000],
                    ['days' => 10, 'oneDay' => 1000, 'allPrice' => 10000], ['days' => 15, 'oneDay' => 1000, 'allPrice' => 10000],
                    ['days' => 20, 'oneDay' => 1000, 'allPrice' => 10000]]],
            ['title' => 'Выделение цветом', 'description' => 'Lorem ipsum dolor sit amet,consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar sic tempor. Sociis natoque penatibus et magnis dis parturient montes',
                'price' => ["id" => 1, 'days' => 3, 'data' => [['days' => 7, 'oneDay' => 1000, 'allPrice' => 10000],
                    ['days' => 10, 'oneDay' => 1000, 'allPrice' => 10000], ['days' => 15, 'oneDay' => 1000, 'allPrice' => 10000],
                    ['days' => 20, 'oneDay' => 1000, 'allPrice' => 10000]]]],
            ['title' => 'Отметка VIP', 'description' => 'Lorem ipsum dolor sit amet,consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar sic tempor. Sociis natoque penatibus et magnis dis parturient montes', 'price' => [
                'price' => ["id" => 1, 'days' => 3, 'data' => [['days' => 7, 'oneDay' => 1000, 'allPrice' => 10000],
                    ['days' => 10, 'oneDay' => 1000, 'allPrice' => 10000], ['days' => 15, 'oneDay' => 1000, 'allPrice' => 10000],
                    ['days' => 20, 'oneDay' => 1000, 'allPrice' => 10000]]]]]
        ];
        foreach ($rates as $rate) {
            RateAdvertisment::create($rate);
        }
    }
}
