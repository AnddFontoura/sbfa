<?php

namespace App\Http\Controllers;

use App\Matches;
use App\PlayerInvited;
use App\Team;
use App\UserProfile;
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
        $userHasValidEmail = Auth::user()->email_verified_at;

        $playerInvitedToAnyTeam = PlayerInvited::where('email', $userEmail)->get();

        $countPlayers = UserProfile::where('is_player', true)->count('id');
        $countTeams = Team::count('id');
        $countMatches = Matches::where('match_datetime', '>', 'NOW()')->count('id');

        return view('home', compact(
            'playerInvitedToAnyTeam', 
            'userHasValidEmail', 
            'countPlayers',
            'countTeams',
            'countMatches',
        ));
    }
}
