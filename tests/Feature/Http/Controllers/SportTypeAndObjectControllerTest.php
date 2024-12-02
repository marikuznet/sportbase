<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\SportObject;
use App\Models\SportType;
use App\Models\SportTypeAndObject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SportTypeAndObjectController
 */
class SportTypeAndObjectControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $sportTypeAndObjects = SportTypeAndObject::factory()->count(3)->create();

        $response = $this->get(route('sport-type-and-object.index'));

        $response->assertOk();
        $response->assertViewIs('sportTypeAndObject.index');
        $response->assertViewHas('sportTypeAndObjects');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('sport-type-and-object.create'));

        $response->assertOk();
        $response->assertViewIs('sportTypeAndObject.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SportTypeAndObjectController::class,
            'store',
            \App\Http\Requests\SportTypeAndObjectStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $sportObject = SportObject::factory()->create();
        $sportType = SportType::factory()->create();

        $response = $this->post(route('sport-type-and-object.store'), [
            'sportObject_id' => $sportObject->id,
            'sportType_id' => $sportType->id,
        ]);

        $sportTypeAndObjects = SportTypeAndObject::query()
            ->where('sportObject_id', $sportObject->id)
            ->where('sportType_id', $sportType->id)
            ->get();
        $this->assertCount(1, $sportTypeAndObjects);
        $sportTypeAndObject = $sportTypeAndObjects->first();

        $response->assertRedirect(route('sportTypeAndObject.index'));
        $response->assertSessionHas('sportTypeAndObject.id', $sportTypeAndObject->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $sportTypeAndObject = SportTypeAndObject::factory()->create();

        $response = $this->get(route('sport-type-and-object.show', $sportTypeAndObject));

        $response->assertOk();
        $response->assertViewIs('sportTypeAndObject.show');
        $response->assertViewHas('sportTypeAndObject');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $sportTypeAndObject = SportTypeAndObject::factory()->create();

        $response = $this->get(route('sport-type-and-object.edit', $sportTypeAndObject));

        $response->assertOk();
        $response->assertViewIs('sportTypeAndObject.edit');
        $response->assertViewHas('sportTypeAndObject');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SportTypeAndObjectController::class,
            'update',
            \App\Http\Requests\SportTypeAndObjectUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $sportTypeAndObject = SportTypeAndObject::factory()->create();
        $sportObject = SportObject::factory()->create();
        $sportType = SportType::factory()->create();

        $response = $this->put(route('sport-type-and-object.update', $sportTypeAndObject), [
            'sportObject_id' => $sportObject->id,
            'sportType_id' => $sportType->id,
        ]);

        $sportTypeAndObject->refresh();

        $response->assertRedirect(route('sportTypeAndObject.index'));
        $response->assertSessionHas('sportTypeAndObject.id', $sportTypeAndObject->id);

        $this->assertEquals($sportObject->id, $sportTypeAndObject->sportObject_id);
        $this->assertEquals($sportType->id, $sportTypeAndObject->sportType_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $sportTypeAndObject = SportTypeAndObject::factory()->create();

        $response = $this->delete(route('sport-type-and-object.destroy', $sportTypeAndObject));

        $response->assertRedirect(route('sportTypeAndObject.index'));

        $this->assertDeleted($sportTypeAndObject);
    }
}
