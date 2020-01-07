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
}
