<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;
use App\Invite;
use Spinen\MailAssertions\MailTracking;

class InviteTest extends TestCase
{
    use RefreshDatabase,
        MailTracking;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testShouldShowInvitePage()
    {
        $user = factory(\App\User::class)->create();

        $response = $this->actingAs($user)->get('/invite');

        $response->assertStatus(200)
            ->assertViewIs('invite');
            //->assertViewHas('reviews', $reviews);
    }

    public function testShouldSendInvite()
    {
        $user = factory(\App\User::class)->create();
        $invitee = 'joe@example.com';

        $response = $this->actingAs($user)->post('/invite', [
            'email' => $invitee
        ]);

        $response->assertStatus(302)
            ->assertRedirect('/')
            ->assertSessionHas('status', 'Invite sent!');

        $this->assertDatabaseHas('invites', [
            'user_id' => $user->id,
            'invitee_email' => $invitee,
            'accepted_at' => NULL
        ]);
    }

    public function testEmailShouldBeRequired()
    {
        $user = factory(\App\User::class)->create();
        $invitee = 'joe@example.com';

        $response = $this->actingAs($user)->post('/invite', []);

        $response->assertStatus(302)
            ->assertRedirect('/')
            ->assertSessionMissing('status');
    }

    public function testInviteShouldBeUniqueForEachEmail()
    {
        $user = factory(\App\User::class)->create();
        $invitee = 'joe@example.com';
        $token = Str::random(12);

        Invite::create([
            'user_id' => $user->id,
            'invitee_email' => $invitee,
            'token' => $token
        ]);

        $response = $this->actingAs($user)->post('/invite', [
            'email' => $invitee
        ]);

        $response->assertStatus(302)
            ->assertRedirect('/')
            ->assertSessionMissing('status');
    }

    public function testInviteShouldBeToValidEmail()
    {
        $user = factory(\App\User::class)->create();
        $invitee = 'invalid';

        $response = $this->actingAs($user)->post('/invite', [
            'email' => $invitee
        ]);

        $response->assertStatus(302)
            ->assertRedirect('/')
            ->assertSessionMissing('status');
    }

    public function testMailShouldBeSent()
    {
        $user = factory(\App\User::class)->create();
        $invitee = 'foo@bar.com';

        $response = $this->actingAs($user)->post('/invite', [
            'email' => $invitee
        ]);

        $this->seeEmailWasSent()
            ->seeEmailTo($invitee);
    }
}
