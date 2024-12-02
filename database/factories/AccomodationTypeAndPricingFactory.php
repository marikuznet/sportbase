<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\AccomodationType;
use App\Models\AccomodationTypeAndPricing;

class AccomodationTypeAndPricingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AccomodationTypeAndPricing::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'accomodationType_id' => AccomodationType::factory(),
            'description' => $this->faker->text,
            'price' => '{}',
        ];
    }
}
