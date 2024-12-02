<?php

namespace Database\Seeders;

use App\Models\ServiceAndObject;
use Illuminate\Database\Seeder;

class ServiceAndObjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ServiceAndObject::factory()->count(5)->create();
    }
}
