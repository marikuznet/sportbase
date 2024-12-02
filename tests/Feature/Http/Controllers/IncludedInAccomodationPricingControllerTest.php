<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\IncludedInAccomodationPricing;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\IncludedInAccomodationPricingController
 */
class IncludedInAccomodationPricingControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $includedInAccomodationPricings = IncludedInAccomodationPricing::factory()->count(3)->create();

        $response = $this->get(route('included-in-accomodation-pricing.index'));

        $response->assertOk();
        $response->assertViewIs('includedInAccomodationPricing.index');
        $response->assertViewHas('includedInAccomodationPricings');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('included-in-accomodation-pricing.create'));

        $response->assertOk();
        $response->assertViewIs('includedInAccomodationPricing.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\IncludedInAccomodationPricingController::class,
            'store',
            \App\Http\Requests\IncludedInAccomodationPricingStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $title = $this->faker->sentence(4);

        $response = $this->post(route('included-in-accomodation-pricing.store'), [
            'title' => $title,
        ]);

        $includedInAccomodationPricings = IncludedInAccomodationPricing::query()
            ->where('title', $title)
            ->get();
        $this->assertCount(1, $includedInAccomodationPricings);
        $includedInAccomodationPricing = $includedInAccomodationPricings->first();

        $response->assertRedirect(route('includedInAccomodationPricing.index'));
        $response->assertSessionHas('includedInAccomodationPricing.id', $includedInAccomodationPricing->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $includedInAccomodationPricing = IncludedInAccomodationPricing::factory()->create();

        $response = $this->get(route('included-in-accomodation-pricing.show', $includedInAccomodationPricing));

        $response->assertOk();
        $response->assertViewIs('includedInAccomodationPricing.show');
        $response->assertViewHas('includedInAccomodationPricing');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $includedInAccomodationPricing = IncludedInAccomodationPricing::factory()->create();

        $response = $this->get(route('included-in-accomodation-pricing.edit', $includedInAccomodationPricing));

        $response->assertOk();
        $response->assertViewIs('includedInAccomodationPricing.edit');
        $response->assertViewHas('includedInAccomodationPricing');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\IncludedInAccomodationPricingController::class,
            'update',
            \App\Http\Requests\IncludedInAccomodationPricingUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $includedInAccomodationPricing = IncludedInAccomodationPricing::factory()->create();
        $title = $this->faker->sentence(4);

        $response = $this->put(route('included-in-accomodation-pricing.update', $includedInAccomodationPricing), [
            'title' => $title,
        ]);

        $includedInAccomodationPricing->refresh();

        $response->assertRedirect(route('includedInAccomodationPricing.index'));
        $response->assertSessionHas('includedInAccomodationPricing.id', $includedInAccomodationPricing->id);

        $this->assertEquals($title, $includedInAccomodationPricing->title);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $includedInAccomodationPricing = IncludedInAccomodationPricing::factory()->create();

        $response = $this->delete(route('included-in-accomodation-pricing.destroy', $includedInAccomodationPricing));

        $response->assertRedirect(route('includedInAccomodationPricing.index'));

        $this->assertDeleted($includedInAccomodationPricing);
    }
}
