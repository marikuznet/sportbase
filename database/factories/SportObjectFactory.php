<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\AccomodationConditionAndPricing;
use App\Models\City;
use App\Models\Infrastructure;
use App\Models\ObjectType;
use App\Models\SportObject;
use App\Models\SportType;

class SportObjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SportObject::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(4),
            'objectType_id' => ObjectType::factory(),
            'image' => '{}',
            'description' => $this->faker->text,
            'sportType_id' => SportType::factory(),
            'accomodationConditionAndPricing_id' => AccomodationConditionAndPricing::factory(),
            'infrastructure_id' => Infrastructure::factory(),
            'city_id' => City::factory(),
            'address' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'postIndex' => $this->faker->numberBetween(-10000, 10000),
            'longtitude' => $this->faker->randomFloat(0, 0, 9999999999.),
            'latitude' => $this->faker->latitude,
            'rating' => $this->faker->randomFloat(0, 0, 9999999999.),
            'feedback_id' => '{}',
            'user_id' => $this->faker->numberBetween(-10000, 10000),
            'hasPromotion' => $this->faker->boolean,
            'hasHighlightion' => $this->faker->boolean,
            'hasVIP' => $this->faker->boolean,
        ];
    }
}
