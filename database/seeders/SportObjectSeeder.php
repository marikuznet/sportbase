<?php

namespace Database\Seeders;

use App\Models\SportObject;
use Illuminate\Database\Seeder;

class SportObjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SportObject::factory()->count(5)->create();
    }
}
