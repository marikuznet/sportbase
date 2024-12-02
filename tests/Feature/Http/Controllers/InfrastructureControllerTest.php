<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Infrastructure;
use App\Models\Option;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\InfrastructureController
 */
class InfrastructureControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $infrastructures = Infrastructure::factory()->count(3)->create();

        $response = $this->get(route('infrastructure.index'));

        $response->assertOk();
        $response->assertViewIs('infrastructure.index');
        $response->assertViewHas('infrastructures');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('infrastructure.create'));

        $response->assertOk();
        $response->assertViewIs('infrastructure.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\InfrastructureController::class,
            'store',
            \App\Http\Requests\InfrastructureStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $title = $this->faker->sentence(4);
        $image = $this->faker->;
        $option = Option::factory()->create();

        $response = $this->post(route('infrastructure.store'), [
            'title' => $title,
            'image' => $image,
            'option_id' => $option->id,
        ]);

        $infrastructures = Infrastructure::query()
            ->where('title', $title)
            ->where('image', $image)
            ->where('option_id', $option->id)
            ->get();
        $this->assertCount(1, $infrastructures);
        $infrastructure = $infrastructures->first();

        $response->assertRedirect(route('infrastructure.index'));
        $response->assertSessionHas('infrastructure.id', $infrastructure->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $infrastructure = Infrastructure::factory()->create();

        $response = $this->get(route('infrastructure.show', $infrastructure));

        $response->assertOk();
        $response->assertViewIs('infrastructure.show');
        $response->assertViewHas('infrastructure');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $infrastructure = Infrastructure::factory()->create();

        $response = $this->get(route('infrastructure.edit', $infrastructure));

        $response->assertOk();
        $response->assertViewIs('infrastructure.edit');
        $response->assertViewHas('infrastructure');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\InfrastructureController::class,
            'update',
            \App\Http\Requests\InfrastructureUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $infrastructure = Infrastructure::factory()->create();
        $title = $this->faker->sentence(4);
        $image = $this->faker->;
        $option = Option::factory()->create();

        $response = $this->put(route('infrastructure.update', $infrastructure), [
            'title' => $title,
            'image' => $image,
            'option_id' => $option->id,
        ]);

        $infrastructure->refresh();

        $response->assertRedirect(route('infrastructure.index'));
        $response->assertSessionHas('infrastructure.id', $infrastructure->id);

        $this->assertEquals($title, $infrastructure->title);
        $this->assertEquals($image, $infrastructure->image);
        $this->assertEquals($option->id, $infrastructure->option_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $infrastructure = Infrastructure::factory()->create();

        $response = $this->delete(route('infrastructure.destroy', $infrastructure));

        $response->assertRedirect(route('infrastructure.index'));

        $this->assertDeleted($infrastructure);
    }
}
