<?php

namespace App\Http\Controllers;

use App\Matches;
use App\PlayerInvited;
use App\Team;
use App\TeamHasPlayers;
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
        $userId = Auth::user()->id;
        $userHasValidEmail = Auth::user()->email_verified_at;

        $playerInvitedToAnyTeam = PlayerInvited::where('email', $userEmail)->get();

        $teamsYouJoin = Team::select('teams.*')
            ->leftJoin('teams_has_players', 'teams_has_players.team_id', 'teams.id')
            ->where('owner_id', $userId)
            ->orWhere('user_id', $userId)
            ->get();
            
        return view('home', compact(
            'playerInvitedToAnyTeam', 
            'userHasValidEmail', 
            'teamsYouJoin'
        ));
    }
}
