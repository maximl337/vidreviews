<?php

namespace App\Http\Controllers;

use App\Invite;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\SendInviteMail;
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
            'email' => 'required|email|unique:invites,invitee_email'
        ]);
        $user = $request->user();
        $token = Str::random(12);
        $invite = Invite::create([
            'invitee_email' => $request->email,
            'user_id' => $request->user()->id,
            'token' => $token
        ]);
        Mail::to($invite->invitee_email)->send(new SendInviteMail($invite, $user));
        return redirect('/')->with(['status' => 'Invite sent!']);
    }

    public function acceptInvite($token, $email)
    {

    }
}
