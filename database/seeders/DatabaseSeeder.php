<?php

namespace Database\Seeders;

use App\Models\AccomodationType;
use App\Models\Profile\EventNotification;
use App\Models\Service;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CountrySeeder::class,
            SportTypeSeeder::class,
            RegionSeeder::class,
            ObjectTypeSeeder::class,
            ServiceSeeder::class,
            PositionSeeder::class,
            CitySeeder::class,
            AccomodationTypeSeeder::class,
            StatusAdvertismentSeeder::class,
            RateAdvertismentSeeder::class,
            EventNotificationSeeder::class,
            RejectionDealSeeder::class,
        ]);
    }
}
