<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Review;
use Illuminate\Support\Facades\Gate;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $reviews = $request->user()
                    ->reviews()
                    ->with('reviewer')
                    ->get()
                    ->toArray();

        return view('home', compact('reviews'));
    }

    /**
     * Approve a review
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function approveReview(Request $request)
    {
        $this->validate($request, [
            'review_id' => 'required|exists:reviews,id'
        ]);

        $review = Review::findOrFail($request->get('review_id'));

        if (Gate::denies('update-review', $review)) {
            return redirect('/')->withErrors(['Authorization', 'You are not authorized for that action.']);
        }

        $review->update([
            'approved_at' => now()
        ]);
        return redirect('/')->with('status', 'Review was approved!');
    }

    /**
     * Approve a review
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function disapproveReview(Request $request)
    {
        $this->validate($request, [
            'review_id' => 'required|exists:reviews,id'
        ]);

        $review = Review::findOrFail($request->get('review_id'));

        if (Gate::denies('update-review', $review)) {
            return redirect('/')->withErrors(['Authorization', 'You are not authorized for that action.']);
        }

        $review->update([
            'approved_at' => NULL
        ]);
        return redirect('/')->with('status', 'Review was disapproved!');
    }
}
