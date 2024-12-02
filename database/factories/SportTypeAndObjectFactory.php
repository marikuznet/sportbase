<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\SportObject;
use App\Models\SportType;
use App\Models\SportTypeAndObject;

class SportTypeAndObjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SportTypeAndObject::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'sportObject_id' => SportObject::factory(),
            'sportType_id' => SportType::factory(),
        ];
    }
}
