<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\AccomodationType;
use App\Models\AccomodationTypeAndPricing;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AccomodationTypeAndPricingController
 */
class AccomodationTypeAndPricingControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $accomodationTypeAndPricings = AccomodationTypeAndPricing::factory()->count(3)->create();

        $response = $this->get(route('accomodation-type-and-pricing.index'));

        $response->assertOk();
        $response->assertViewIs('accomodationTypeAndPricing.index');
        $response->assertViewHas('accomodationTypeAndPricings');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('accomodation-type-and-pricing.create'));

        $response->assertOk();
        $response->assertViewIs('accomodationTypeAndPricing.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AccomodationTypeAndPricingController::class,
            'store',
            \App\Http\Requests\AccomodationTypeAndPricingStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $accomodationType = AccomodationType::factory()->create();
        $description = $this->faker->text;
        $price = $this->faker->;

        $response = $this->post(route('accomodation-type-and-pricing.store'), [
            'accomodationType_id' => $accomodationType->id,
            'description' => $description,
            'price' => $price,
        ]);

        $accomodationTypeAndPricings = AccomodationTypeAndPricing::query()
            ->where('accomodationType_id', $accomodationType->id)
            ->where('description', $description)
            ->where('price', $price)
            ->get();
        $this->assertCount(1, $accomodationTypeAndPricings);
        $accomodationTypeAndPricing = $accomodationTypeAndPricings->first();

        $response->assertRedirect(route('accomodationTypeAndPricing.index'));
        $response->assertSessionHas('accomodationTypeAndPricing.id', $accomodationTypeAndPricing->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $accomodationTypeAndPricing = AccomodationTypeAndPricing::factory()->create();

        $response = $this->get(route('accomodation-type-and-pricing.show', $accomodationTypeAndPricing));

        $response->assertOk();
        $response->assertViewIs('accomodationTypeAndPricing.show');
        $response->assertViewHas('accomodationTypeAndPricing');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $accomodationTypeAndPricing = AccomodationTypeAndPricing::factory()->create();

        $response = $this->get(route('accomodation-type-and-pricing.edit', $accomodationTypeAndPricing));

        $response->assertOk();
        $response->assertViewIs('accomodationTypeAndPricing.edit');
        $response->assertViewHas('accomodationTypeAndPricing');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AccomodationTypeAndPricingController::class,
            'update',
            \App\Http\Requests\AccomodationTypeAndPricingUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $accomodationTypeAndPricing = AccomodationTypeAndPricing::factory()->create();
        $accomodationType = AccomodationType::factory()->create();
        $description = $this->faker->text;
        $price = $this->faker->;

        $response = $this->put(route('accomodation-type-and-pricing.update', $accomodationTypeAndPricing), [
            'accomodationType_id' => $accomodationType->id,
            'description' => $description,
            'price' => $price,
        ]);

        $accomodationTypeAndPricing->refresh();

        $response->assertRedirect(route('accomodationTypeAndPricing.index'));
        $response->assertSessionHas('accomodationTypeAndPricing.id', $accomodationTypeAndPricing->id);

        $this->assertEquals($accomodationType->id, $accomodationTypeAndPricing->accomodationType_id);
        $this->assertEquals($description, $accomodationTypeAndPricing->description);
        $this->assertEquals($price, $accomodationTypeAndPricing->price);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $accomodationTypeAndPricing = AccomodationTypeAndPricing::factory()->create();

        $response = $this->delete(route('accomodation-type-and-pricing.destroy', $accomodationTypeAndPricing));

        $response->assertRedirect(route('accomodationTypeAndPricing.index'));

        $this->assertDeleted($accomodationTypeAndPricing);
    }
}
