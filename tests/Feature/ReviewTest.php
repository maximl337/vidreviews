<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testShouldReturn302ForUnauthenticated()
    {
        $response = $this->get('/');

        $response->assertStatus(302);
    }

    public function testShouldReturn200FormAuthenticated()
    {
        $user = factory(\App\User::class)->create();

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
    }

    public function testShouldReturnReviews()
    {
        $user = factory(\App\User::class)->create();

        $reviewers = factory(\App\User::class, 2)->create();

        foreach($reviewers as $reviewer) {
            factory(\App\Review::class)->create([
                'user_id' => $user->id,
                'reviewer_id' => $reviewer->id
            ]);
        }

        $reviews = \App\Review::where('user_id', $user->id)->with('reviewer')->get()->toArray();

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200)
            ->assertViewIs('home')
            ->assertViewHas('reviews', $reviews);
    }

    public function testApproveReview()
    {
        $user = factory(\App\User::class)->create();

        $reviewers = factory(\App\User::class, 2)->create();

        foreach($reviewers as $reviewer) {
            factory(\App\Review::class)->create([
                'user_id' => $user->id,
                'reviewer_id' => $reviewer->id
            ]);
        }

        $review = \App\Review::where('user_id', $user->id)->with('reviewer')->first();

        $response = $this->actingAs($user)->post('/review/approve', [
            'review_id' => $review->id
        ]);

        $response->assertStatus(302)
            ->assertRedirect('/')
            ->assertSessionHas('status', 'Review was approved!');

        $this->assertDatabaseHas('reviews', [
            'id' => $review->id,
            'approved_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }

    public function testShouldNotAllow()
    {
        $user = factory(\App\User::class)->create();

        $reviewers = factory(\App\User::class, 2)->create();

        foreach($reviewers as $reviewer) {
            factory(\App\Review::class)->create([
                'user_id' => $user->id,
                'reviewer_id' => $reviewer->id
            ]);
        }

        $review = \App\Review::where('user_id', $user->id)->with('reviewer')->first();

        $response = $this->actingAs($user)->post('/review/approve', []);

        $response->assertStatus(302)
            ->assertRedirect('/')
            ->assertSessionHasErrors(['review_id']);

        $this->assertDatabaseMissing('reviews', [
            'id' => $review->id,
            'approved_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }

    public function testAnotherUserCannotApproveReview()
    {
        $user = factory(\App\User::class)->create();

        $unauthorizedUser = factory(\App\User::class)->create();

        $reviewers = factory(\App\User::class, 2)->create();

        foreach($reviewers as $reviewer) {
            factory(\App\Review::class)->create([
                'user_id' => $user->id,
                'reviewer_id' => $reviewer->id
            ]);
        }

        $review = \App\Review::where('user_id', $user->id)->with('reviewer')->first();

        $response = $this->actingAs($unauthorizedUser)->post('/review/approve', []);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('reviews', [
            'id' => $review->id,
            'approved_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
