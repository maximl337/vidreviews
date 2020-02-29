<?php

namespace App\Http\Controllers;

use App\Invite;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\SendInviteMail;
use App\Review;
use Mail;

class InviteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * [invite description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function invite(Request $request)
    {
        $user = $request->user();

        $placeholder = "Hello, &#10$user->name has requested a video review from you. Please click on the link below to add one. This will only take a few minutes.";
        //$invites = Invite::where()
        return view('invite', compact('placeholder'));
    }

    /**
     * [sendInvite description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function sendInvite(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email'
        ]);
        $user = $request->user();
        $token = Str::random(12);
        $invite = Invite::create([
            'invitee_email' => $request->email,
            'user_id' => $user->id,
            'token' => $token
        ]);
        $url = route('accept-invite', [
            'token' => $token,
            'email' => $request->email
        ]);
        Mail::to($invite->invitee_email)->send(new SendInviteMail($invite, $user));
        return redirect('/')->with(['status' => 'Invite sent! Here is the link: ' . $url]);
    }

    /**
     * [acceptInvite description]
     * @param  [type] $email [description]
     * @param  [type] $token [description]
     * @return [type]        [description]
     */
    public function acceptInvite($email, $token)
    {
        $invite = Invite::where('token', $token)
                    ->where('invitee_email', $email)
                    ->whereNull('submitted_at')
                    ->firstOrFail();
        $invite->update([
            'accepted_at' => now()
        ]);
        return view('accept-invite', compact('email', 'token', 'invite'));
    }

    /**
     * [submitInvite description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function submitReview(Request $request)
    {
        $this->validate($request, [
            'invite_id' => 'required|exists:invites,id',
            'ziggeo_token' => 'required'
        ]);
        $input = $request->input();
        $invite = Invite::findOrFail($input['invite_id']);
        $invite->submitted_at = now();
        $invite->update();
        $review = Review::create([
            'user_id' => $invite->user_id,
            'reviewer_id' => $request->user()->id,
            'token' => $input['ziggeo_token']
        ]);
        return view('thankyou');
    }
}
