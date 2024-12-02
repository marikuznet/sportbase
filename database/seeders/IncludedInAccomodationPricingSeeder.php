<?php

namespace Database\Seeders;

use App\Models\IncludedInAccomodationPricing;
use Illuminate\Database\Seeder;

class IncludedInAccomodationPricingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        IncludedInAccomodationPricing::factory()->count(5)->create();
    }
}
