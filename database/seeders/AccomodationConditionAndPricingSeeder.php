<?php

namespace Database\Seeders;

use App\Models\AccomodationConditionAndPricing;
use Illuminate\Database\Seeder;

class AccomodationConditionAndPricingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AccomodationConditionAndPricing::factory()->count(5)->create();
    }
}
