<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\AccomodationConditionAndPricing;
use App\Models\City;
use App\Models\Infrastructure;
use App\Models\ObjectType;
use App\Models\SportObject;
use App\Models\SportType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SportObjectController
 */
class SportObjectControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $sportObjects = SportObject::factory()->count(3)->create();

        $response = $this->get(route('sport-object.index'));

        $response->assertOk();
        $response->assertViewIs('sportObject.index');
        $response->assertViewHas('sportObjects');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('sport-object.create'));

        $response->assertOk();
        $response->assertViewIs('sportObject.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SportObjectController::class,
            'store',
            \App\Http\Requests\SportObjectStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $title = $this->faker->sentence(4);
        $objectType = ObjectType::factory()->create();
        $image = $this->faker->;
        $description = $this->faker->text;
        $sportType = SportType::factory()->create();
        $accomodationConditionAndPricing = AccomodationConditionAndPricing::factory()->create();
        $infrastructure = Infrastructure::factory()->create();
        $city = City::factory()->create();
        $address = $this->faker->word;
        $postIndex = $this->faker->numberBetween(-10000, 10000);
        $longtitude = $this->faker->randomFloat(/** float_attributes **/);
        $latitude = $this->faker->latitude;
        $rating = $this->faker->randomFloat(/** float_attributes **/);
        $feedback_id = $this->faker->;
        $user_id = $this->faker->numberBetween(-10000, 10000);
        $hasPromotion = $this->faker->boolean;
        $hasHighlightion = $this->faker->boolean;
        $hasVIP = $this->faker->boolean;

        $response = $this->post(route('sport-object.store'), [
            'title' => $title,
            'objectType_id' => $objectType->id,
            'image' => $image,
            'description' => $description,
            'sportType_id' => $sportType->id,
            'accomodationConditionAndPricing_id' => $accomodationConditionAndPricing->id,
            'infrastructure_id' => $infrastructure->id,
            'city_id' => $city->id,
            'address' => $address,
            'postIndex' => $postIndex,
            'longtitude' => $longtitude,
            'latitude' => $latitude,
            'rating' => $rating,
            'feedback_id' => $feedback_id,
            'user_id' => $user_id,
            'hasPromotion' => $hasPromotion,
            'hasHighlightion' => $hasHighlightion,
            'hasVIP' => $hasVIP,
        ]);

        $sportObjects = SportObject::query()
            ->where('title', $title)
            ->where('objectType_id', $objectType->id)
            ->where('image', $image)
            ->where('description', $description)
            ->where('sportType_id', $sportType->id)
            ->where('accomodationConditionAndPricing_id', $accomodationConditionAndPricing->id)
            ->where('infrastructure_id', $infrastructure->id)
            ->where('city_id', $city->id)
            ->where('address', $address)
            ->where('postIndex', $postIndex)
            ->where('longtitude', $longtitude)
            ->where('latitude', $latitude)
            ->where('rating', $rating)
            ->where('feedback_id', $feedback_id)
            ->where('user_id', $user_id)
            ->where('hasPromotion', $hasPromotion)
            ->where('hasHighlightion', $hasHighlightion)
            ->where('hasVIP', $hasVIP)
            ->get();
        $this->assertCount(1, $sportObjects);
        $sportObject = $sportObjects->first();

        $response->assertRedirect(route('sportObject.index'));
        $response->assertSessionHas('sportObject.id', $sportObject->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $sportObject = SportObject::factory()->create();

        $response = $this->get(route('sport-object.show', $sportObject));

        $response->assertOk();
        $response->assertViewIs('sportObject.show');
        $response->assertViewHas('sportObject');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $sportObject = SportObject::factory()->create();

        $response = $this->get(route('sport-object.edit', $sportObject));

        $response->assertOk();
        $response->assertViewIs('sportObject.edit');
        $response->assertViewHas('sportObject');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SportObjectController::class,
            'update',
            \App\Http\Requests\SportObjectUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $sportObject = SportObject::factory()->create();
        $title = $this->faker->sentence(4);
        $objectType = ObjectType::factory()->create();
        $image = $this->faker->;
        $description = $this->faker->text;
        $sportType = SportType::factory()->create();
        $accomodationConditionAndPricing = AccomodationConditionAndPricing::factory()->create();
        $infrastructure = Infrastructure::factory()->create();
        $city = City::factory()->create();
        $address = $this->faker->word;
        $postIndex = $this->faker->numberBetween(-10000, 10000);
        $longtitude = $this->faker->randomFloat(/** float_attributes **/);
        $latitude = $this->faker->latitude;
        $rating = $this->faker->randomFloat(/** float_attributes **/);
        $feedback_id = $this->faker->;
        $user_id = $this->faker->numberBetween(-10000, 10000);
        $hasPromotion = $this->faker->boolean;
        $hasHighlightion = $this->faker->boolean;
        $hasVIP = $this->faker->boolean;

        $response = $this->put(route('sport-object.update', $sportObject), [
            'title' => $title,
            'objectType_id' => $objectType->id,
            'image' => $image,
            'description' => $description,
            'sportType_id' => $sportType->id,
            'accomodationConditionAndPricing_id' => $accomodationConditionAndPricing->id,
            'infrastructure_id' => $infrastructure->id,
            'city_id' => $city->id,
            'address' => $address,
            'postIndex' => $postIndex,
            'longtitude' => $longtitude,
            'latitude' => $latitude,
            'rating' => $rating,
            'feedback_id' => $feedback_id,
            'user_id' => $user_id,
            'hasPromotion' => $hasPromotion,
            'hasHighlightion' => $hasHighlightion,
            'hasVIP' => $hasVIP,
        ]);

        $sportObject->refresh();

        $response->assertRedirect(route('sportObject.index'));
        $response->assertSessionHas('sportObject.id', $sportObject->id);

        $this->assertEquals($title, $sportObject->title);
        $this->assertEquals($objectType->id, $sportObject->objectType_id);
        $this->assertEquals($image, $sportObject->image);
        $this->assertEquals($description, $sportObject->description);
        $this->assertEquals($sportType->id, $sportObject->sportType_id);
        $this->assertEquals($accomodationConditionAndPricing->id, $sportObject->accomodationConditionAndPricing_id);
        $this->assertEquals($infrastructure->id, $sportObject->infrastructure_id);
        $this->assertEquals($city->id, $sportObject->city_id);
        $this->assertEquals($address, $sportObject->address);
        $this->assertEquals($postIndex, $sportObject->postIndex);
        $this->assertEquals($longtitude, $sportObject->longtitude);
        $this->assertEquals($latitude, $sportObject->latitude);
        $this->assertEquals($rating, $sportObject->rating);
        $this->assertEquals($feedback_id, $sportObject->feedback_id);
        $this->assertEquals($user_id, $sportObject->user_id);
        $this->assertEquals($hasPromotion, $sportObject->hasPromotion);
        $this->assertEquals($hasHighlightion, $sportObject->hasHighlightion);
        $this->assertEquals($hasVIP, $sportObject->hasVIP);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $sportObject = SportObject::factory()->create();

        $response = $this->delete(route('sport-object.destroy', $sportObject));

        $response->assertRedirect(route('sportObject.index'));

        $this->assertDeleted($sportObject);
    }
}
