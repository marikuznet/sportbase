<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\AccomodationConditionAndPricing;
use App\Models\AccomodationTypeAndPricing;
use App\Models\IncludedInAccomodationPricing;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AccomodationConditionAndPricingController
 */
class AccomodationConditionAndPricingControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $accomodationConditionAndPricings = AccomodationConditionAndPricing::factory()->count(3)->create();

        $response = $this->get(route('accomodation-condition-and-pricing.index'));

        $response->assertOk();
        $response->assertViewIs('accomodationConditionAndPricing.index');
        $response->assertViewHas('accomodationConditionAndPricings');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('accomodation-condition-and-pricing.create'));

        $response->assertOk();
        $response->assertViewIs('accomodationConditionAndPricing.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AccomodationConditionAndPricingController::class,
            'store',
            \App\Http\Requests\AccomodationConditionAndPricingStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $description = $this->faker->text;
        $includedInAccomodationPricing = IncludedInAccomodationPricing::factory()->create();
        $image = [];
        $accomodationTypeAndPricing = AccomodationTypeAndPricing::factory()->create();

        $response = $this->post(route('accomodation-condition-and-pricing.store'), [
            'description' => $description,
            'includedInAccomodationPricing_id' => $includedInAccomodationPricing->id,
            'image' => $image,
            'accomodationTypeAndPricing_id' => $accomodationTypeAndPricing->id,
        ]);

        $accomodationConditionAndPricings = AccomodationConditionAndPricing::query()
            ->where('description', $description)
            ->where('includedInAccomodationPricing_id', $includedInAccomodationPricing->id)
            ->where('image', $image)
            ->where('accomodationTypeAndPricing_id', $accomodationTypeAndPricing->id)
            ->get();
        $this->assertCount(1, $accomodationConditionAndPricings);
        $accomodationConditionAndPricing = $accomodationConditionAndPricings->first();

        $response->assertRedirect(route('accomodationConditionAndPricing.index'));
        $response->assertSessionHas('accomodationConditionAndPricing.id', $accomodationConditionAndPricing->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $accomodationConditionAndPricing = AccomodationConditionAndPricing::factory()->create();

        $response = $this->get(route('accomodation-condition-and-pricing.show', $accomodationConditionAndPricing));

        $response->assertOk();
        $response->assertViewIs('accomodationConditionAndPricing.show');
        $response->assertViewHas('accomodationConditionAndPricing');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $accomodationConditionAndPricing = AccomodationConditionAndPricing::factory()->create();

        $response = $this->get(route('accomodation-condition-and-pricing.edit', $accomodationConditionAndPricing));

        $response->assertOk();
        $response->assertViewIs('accomodationConditionAndPricing.edit');
        $response->assertViewHas('accomodationConditionAndPricing');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AccomodationConditionAndPricingController::class,
            'update',
            \App\Http\Requests\AccomodationConditionAndPricingUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $accomodationConditionAndPricing = AccomodationConditionAndPricing::factory()->create();
        $description = $this->faker->text;
        $includedInAccomodationPricing = IncludedInAccomodationPricing::factory()->create();
        $image = [];
        $accomodationTypeAndPricing = AccomodationTypeAndPricing::factory()->create();

        $response = $this->put(route('accomodation-condition-and-pricing.update', $accomodationConditionAndPricing), [
            'description' => $description,
            'includedInAccomodationPricing_id' => $includedInAccomodationPricing->id,
            'image' => $image,
            'accomodationTypeAndPricing_id' => $accomodationTypeAndPricing->id,
        ]);

        $accomodationConditionAndPricing->refresh();

        $response->assertRedirect(route('accomodationConditionAndPricing.index'));
        $response->assertSessionHas('accomodationConditionAndPricing.id', $accomodationConditionAndPricing->id);

        $this->assertEquals($description, $accomodationConditionAndPricing->description);
        $this->assertEquals($includedInAccomodationPricing->id, $accomodationConditionAndPricing->includedInAccomodationPricing_id);
        $this->assertEquals($image, $accomodationConditionAndPricing->image);
        $this->assertEquals($accomodationTypeAndPricing->id, $accomodationConditionAndPricing->accomodationTypeAndPricing_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $accomodationConditionAndPricing = AccomodationConditionAndPricing::factory()->create();

        $response = $this->delete(route('accomodation-condition-and-pricing.destroy', $accomodationConditionAndPricing));

        $response->assertRedirect(route('accomodationConditionAndPricing.index'));

        $this->assertDeleted($accomodationConditionAndPricing);
    }
}
