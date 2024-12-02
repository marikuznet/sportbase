<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Option;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\OptionController
 */
class OptionControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $options = Option::factory()->count(3)->create();

        $response = $this->get(route('option.index'));

        $response->assertOk();
        $response->assertViewIs('option.index');
        $response->assertViewHas('options');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('option.create'));

        $response->assertOk();
        $response->assertViewIs('option.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\OptionController::class,
            'store',
            \App\Http\Requests\OptionStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $title = $this->faker->sentence(4);

        $response = $this->post(route('option.store'), [
            'title' => $title,
        ]);

        $options = Option::query()
            ->where('title', $title)
            ->get();
        $this->assertCount(1, $options);
        $option = $options->first();

        $response->assertRedirect(route('option.index'));
        $response->assertSessionHas('option.id', $option->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $option = Option::factory()->create();

        $response = $this->get(route('option.show', $option));

        $response->assertOk();
        $response->assertViewIs('option.show');
        $response->assertViewHas('option');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $option = Option::factory()->create();

        $response = $this->get(route('option.edit', $option));

        $response->assertOk();
        $response->assertViewIs('option.edit');
        $response->assertViewHas('option');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\OptionController::class,
            'update',
            \App\Http\Requests\OptionUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $option = Option::factory()->create();
        $title = $this->faker->sentence(4);

        $response = $this->put(route('option.update', $option), [
            'title' => $title,
        ]);

        $option->refresh();

        $response->assertRedirect(route('option.index'));
        $response->assertSessionHas('option.id', $option->id);

        $this->assertEquals($title, $option->title);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $option = Option::factory()->create();

        $response = $this->delete(route('option.destroy', $option));

        $response->assertRedirect(route('option.index'));

        $this->assertDeleted($option);
    }
}
