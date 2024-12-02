<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\FeedbackController
 */
class FeedbackControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $feedback = Feedback::factory()->count(3)->create();

        $response = $this->get(route('feedback.index'));

        $response->assertOk();
        $response->assertViewIs('feedback.index');
        $response->assertViewHas('feedback');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('feedback.create'));

        $response->assertOk();
        $response->assertViewIs('feedback.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\FeedbackController::class,
            'store',
            \App\Http\Requests\FeedbackStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $date = $this->faker->dateTime();
        $content = $this->faker->paragraphs(3, true);
        $rating = $this->faker->randomFloat(/** float_attributes **/);

        $response = $this->post(route('feedback.store'), [
            'date' => $date,
            'content' => $content,
            'rating' => $rating,
        ]);

        $feedback = Feedback::query()
            ->where('date', $date)
            ->where('content', $content)
            ->where('rating', $rating)
            ->get();
        $this->assertCount(1, $feedback);
        $feedback = $feedback->first();

        $response->assertRedirect(route('feedback.index'));
        $response->assertSessionHas('feedback.id', $feedback->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $feedback = Feedback::factory()->create();

        $response = $this->get(route('feedback.show', $feedback));

        $response->assertOk();
        $response->assertViewIs('feedback.show');
        $response->assertViewHas('feedback');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $feedback = Feedback::factory()->create();

        $response = $this->get(route('feedback.edit', $feedback));

        $response->assertOk();
        $response->assertViewIs('feedback.edit');
        $response->assertViewHas('feedback');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\FeedbackController::class,
            'update',
            \App\Http\Requests\FeedbackUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $feedback = Feedback::factory()->create();
        $date = $this->faker->dateTime();
        $content = $this->faker->paragraphs(3, true);
        $rating = $this->faker->randomFloat(/** float_attributes **/);

        $response = $this->put(route('feedback.update', $feedback), [
            'date' => $date,
            'content' => $content,
            'rating' => $rating,
        ]);

        $feedback->refresh();

        $response->assertRedirect(route('feedback.index'));
        $response->assertSessionHas('feedback.id', $feedback->id);

        $this->assertEquals($date, $feedback->date);
        $this->assertEquals($content, $feedback->content);
        $this->assertEquals($rating, $feedback->rating);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $feedback = Feedback::factory()->create();

        $response = $this->delete(route('feedback.destroy', $feedback));

        $response->assertRedirect(route('feedback.index'));

        $this->assertDeleted($feedback);
    }
}
