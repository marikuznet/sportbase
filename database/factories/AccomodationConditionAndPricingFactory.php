<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\AccomodationConditionAndPricing;
use App\Models\AccomodationTypeAndPricing;
use App\Models\IncludedInAccomodationPricing;

class AccomodationConditionAndPricingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AccomodationConditionAndPricing::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description' => $this->faker->text,
            'includedInAccomodationPricing_id' => IncludedInAccomodationPricing::factory(),
            'image' => '{}',
            'accomodationTypeAndPricing_id' => AccomodationTypeAndPricing::factory(),
        ];
    }
}
