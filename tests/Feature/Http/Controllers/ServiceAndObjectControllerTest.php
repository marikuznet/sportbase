<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceAndObject;
use App\Models\SportObject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ServiceAndObjectController
 */
class ServiceAndObjectControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $serviceAndObjects = ServiceAndObject::factory()->count(3)->create();

        $response = $this->get(route('service-and-object.index'));

        $response->assertOk();
        $response->assertViewIs('serviceAndObject.index');
        $response->assertViewHas('serviceAndObjects');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('service-and-object.create'));

        $response->assertOk();
        $response->assertViewIs('serviceAndObject.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ServiceAndObjectController::class,
            'store',
            \App\Http\Requests\ServiceAndObjectStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $sportObject = SportObject::factory()->create();
        $service = Service::factory()->create();

        $response = $this->post(route('service-and-object.store'), [
            'sportObject_id' => $sportObject->id,
            'service_id' => $service->id,
        ]);

        $serviceAndObjects = ServiceAndObject::query()
            ->where('sportObject_id', $sportObject->id)
            ->where('service_id', $service->id)
            ->get();
        $this->assertCount(1, $serviceAndObjects);
        $serviceAndObject = $serviceAndObjects->first();

        $response->assertRedirect(route('serviceAndObject.index'));
        $response->assertSessionHas('serviceAndObject.id', $serviceAndObject->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $serviceAndObject = ServiceAndObject::factory()->create();

        $response = $this->get(route('service-and-object.show', $serviceAndObject));

        $response->assertOk();
        $response->assertViewIs('serviceAndObject.show');
        $response->assertViewHas('serviceAndObject');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $serviceAndObject = ServiceAndObject::factory()->create();

        $response = $this->get(route('service-and-object.edit', $serviceAndObject));

        $response->assertOk();
        $response->assertViewIs('serviceAndObject.edit');
        $response->assertViewHas('serviceAndObject');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ServiceAndObjectController::class,
            'update',
            \App\Http\Requests\ServiceAndObjectUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $serviceAndObject = ServiceAndObject::factory()->create();
        $sportObject = SportObject::factory()->create();
        $service = Service::factory()->create();

        $response = $this->put(route('service-and-object.update', $serviceAndObject), [
            'sportObject_id' => $sportObject->id,
            'service_id' => $service->id,
        ]);

        $serviceAndObject->refresh();

        $response->assertRedirect(route('serviceAndObject.index'));
        $response->assertSessionHas('serviceAndObject.id', $serviceAndObject->id);

        $this->assertEquals($sportObject->id, $serviceAndObject->sportObject_id);
        $this->assertEquals($service->id, $serviceAndObject->service_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $serviceAndObject = ServiceAndObject::factory()->create();

        $response = $this->delete(route('service-and-object.destroy', $serviceAndObject));

        $response->assertRedirect(route('serviceAndObject.index'));

        $this->assertDeleted($serviceAndObject);
    }
}
