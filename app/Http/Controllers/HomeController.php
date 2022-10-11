<?php

namespace App\Http\Controllers;

use App\PlayerInvited;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $userEmail = Auth::user()->email;

        $playerInvitedToAnyTeam = PlayerInvited::where('email', $userEmail)->get();

        return view('home', compact('playerInvitedToAnyTeam'));
    }
}
