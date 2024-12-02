<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\AccomodationType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AccomodationTypeController
 */
class AccomodationTypeControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $accomodationTypes = AccomodationType::factory()->count(3)->create();

        $response = $this->get(route('accomodation-type.index'));

        $response->assertOk();
        $response->assertViewIs('accomodationType.index');
        $response->assertViewHas('accomodationTypes');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('accomodation-type.create'));

        $response->assertOk();
        $response->assertViewIs('accomodationType.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AccomodationTypeController::class,
            'store',
            \App\Http\Requests\AccomodationTypeStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $title = $this->faker->sentence(4);
        $response = $this->post(route('accomodation-type.store'), [
            'title' => $title,
        ]);

        $accomodationTypes = AccomodationType::query()
            ->where('title', $title)
            ->get();
        $this->assertCount(1, $accomodationTypes);
        $accomodationType = $accomodationTypes->first();

        $response->assertRedirect(route('accomodationType.index'));
        $response->assertSessionHas('accomodationType.id', $accomodationType->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $accomodationType = AccomodationType::factory()->create();

        $response = $this->get(route('accomodation-type.show', $accomodationType));

        $response->assertOk();
        $response->assertViewIs('accomodationType.show');
        $response->assertViewHas('accomodationType');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $accomodationType = AccomodationType::factory()->create();

        $response = $this->get(route('accomodation-type.edit', $accomodationType));

        $response->assertOk();
        $response->assertViewIs('accomodationType.edit');
        $response->assertViewHas('accomodationType');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AccomodationTypeController::class,
            'update',
            \App\Http\Requests\AccomodationTypeUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $accomodationType = AccomodationType::factory()->create();
        $title = $this->faker->sentence(4);
        $response = $this->put(route('accomodation-type.update', $accomodationType), [
            'title' => $title,
        ]);
        $accomodationType->refresh();
        $response->assertRedirect(route('accomodationType.index'));
        $response->assertSessionHas('accomodationType.id', $accomodationType->id);
        $this->assertEquals($title, $accomodationType->title);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $accomodationType = AccomodationType::factory()->create();
        $response = $this->delete(route('accomodation-type.destroy', $accomodationType));
        $response->assertRedirect(route('accomodationType.index'));
        $this->assertDeleted($accomodationType);
    }
}
