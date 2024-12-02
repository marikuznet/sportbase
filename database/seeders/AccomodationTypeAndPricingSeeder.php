<?php

namespace Database\Seeders;

use App\Models\AccomodationTypeAndPricing;
use Illuminate\Database\Seeder;

class AccomodationTypeAndPricingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AccomodationTypeAndPricing::factory()->count(5)->create();
    }
}
