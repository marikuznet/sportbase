<?php

namespace Database\Seeders;

use App\Models\SportTypeAndObject;
use Illuminate\Database\Seeder;

class SportTypeAndObjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SportTypeAndObject::factory()->count(5)->create();
    }
}
