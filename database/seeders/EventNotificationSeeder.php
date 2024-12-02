<?php

namespace Database\Seeders;

use App\Models\Profile\EventNotification;
use Illuminate\Database\Seeder;

class EventNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $events = [
            ['title' => 'Поступление заявок на аренду объекта',],
            ['title' => 'Изменение статуса отклика на тендер'],
            ['title' => 'Появление сообщения при заключении Заказ'],
            ['title' => "Выплата средств"],
        ];

        foreach ($events as $event) {
            EventNotification::create($event);
        }
        // Service::factory()->count(5)->create();
    }
}
