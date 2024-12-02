<?php

namespace Database\Seeders;

use App\Models\Advertisment\StatusAdvertisment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class StatusAdvertismentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            ['title' => 'Выполняется'],
            ['title' => 'Просрочен'],
            ['title' => 'Завершена'],
        ];
        foreach ($statuses as $status) {
            StatusAdvertisment::create($status);
        }

        // $user->assignRole('администратор');
    }
}
