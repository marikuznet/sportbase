<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\SportType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SportTypeController
 */
class SportTypeControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $sportTypes = SportType::factory()->count(3)->create();

        $response = $this->get(route('sport-type.index'));

        $response->assertOk();
        $response->assertViewIs('sportType.index');
        $response->assertViewHas('sportTypes');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('sport-type.create'));

        $response->assertOk();
        $response->assertViewIs('sportType.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SportTypeController::class,
            'store',
            \App\Http\Requests\SportTypeStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $title = $this->faker->sentence(4);

        $response = $this->post(route('sport-type.store'), [
            'title' => $title,
        ]);

        $sportTypes = SportType::query()
            ->where('title', $title)
            ->get();
        $this->assertCount(1, $sportTypes);
        $sportType = $sportTypes->first();

        $response->assertRedirect(route('sportType.index'));
        $response->assertSessionHas('sportType.id', $sportType->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $sportType = SportType::factory()->create();

        $response = $this->get(route('sport-type.show', $sportType));

        $response->assertOk();
        $response->assertViewIs('sportType.show');
        $response->assertViewHas('sportType');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $sportType = SportType::factory()->create();

        $response = $this->get(route('sport-type.edit', $sportType));

        $response->assertOk();
        $response->assertViewIs('sportType.edit');
        $response->assertViewHas('sportType');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SportTypeController::class,
            'update',
            \App\Http\Requests\SportTypeUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $sportType = SportType::factory()->create();
        $title = $this->faker->sentence(4);

        $response = $this->put(route('sport-type.update', $sportType), [
            'title' => $title,
        ]);

        $sportType->refresh();

        $response->assertRedirect(route('sportType.index'));
        $response->assertSessionHas('sportType.id', $sportType->id);

        $this->assertEquals($title, $sportType->title);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $sportType = SportType::factory()->create();

        $response = $this->delete(route('sport-type.destroy', $sportType));

        $response->assertRedirect(route('sportType.index'));

        $this->assertDeleted($sportType);
    }
}
