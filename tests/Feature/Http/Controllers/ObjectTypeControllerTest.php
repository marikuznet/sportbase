<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\ObjectType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ObjectTypeController
 */
class ObjectTypeControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $objectTypes = ObjectType::factory()->count(3)->create();

        $response = $this->get(route('object-type.index'));

        $response->assertOk();
        $response->assertViewIs('objectType.index');
        $response->assertViewHas('objectTypes');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('object-type.create'));

        $response->assertOk();
        $response->assertViewIs('objectType.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ObjectTypeController::class,
            'store',
            \App\Http\Requests\ObjectTypeStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $title = $this->faker->sentence(4);

        $response = $this->post(route('object-type.store'), [
            'title' => $title,
        ]);

        $objectTypes = ObjectType::query()
            ->where('title', $title)
            ->get();
        $this->assertCount(1, $objectTypes);
        $objectType = $objectTypes->first();

        $response->assertRedirect(route('objectType.index'));
        $response->assertSessionHas('objectType.id', $objectType->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $objectType = ObjectType::factory()->create();

        $response = $this->get(route('object-type.show', $objectType));

        $response->assertOk();
        $response->assertViewIs('objectType.show');
        $response->assertViewHas('objectType');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $objectType = ObjectType::factory()->create();

        $response = $this->get(route('object-type.edit', $objectType));

        $response->assertOk();
        $response->assertViewIs('objectType.edit');
        $response->assertViewHas('objectType');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ObjectTypeController::class,
            'update',
            \App\Http\Requests\ObjectTypeUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $objectType = ObjectType::factory()->create();
        $title = $this->faker->sentence(4);

        $response = $this->put(route('object-type.update', $objectType), [
            'title' => $title,
        ]);

        $objectType->refresh();

        $response->assertRedirect(route('objectType.index'));
        $response->assertSessionHas('objectType.id', $objectType->id);

        $this->assertEquals($title, $objectType->title);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $objectType = ObjectType::factory()->create();

        $response = $this->delete(route('object-type.destroy', $objectType));

        $response->assertRedirect(route('objectType.index'));

        $this->assertDeleted($objectType);
    }
}
