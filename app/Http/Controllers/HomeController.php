<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Review;

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
        $reviews = $request->user()->reviews()->with('reviewer')->get()->toArray();

        return view('home', compact('reviews'));
    }
}
