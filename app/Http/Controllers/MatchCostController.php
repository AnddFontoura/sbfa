<?php

namespace App\Http\Controllers;

use App\MatchCost;
use App\Matches;
use App\Team;
use Illuminate\Http\Request;

class MatchCostController extends Controller
{
    public function create(int $teamId, int $matchId)
    {
        $team = Team::where('id', $teamId)->first();
        $match = Matches::where('id', $matchId)->first();
        $matchCost = MatchCost::where('team_id', $teamId)
            ->where('match_id', $matchId)
            ->first();

        return view('match_cost.form', compact('team', 'match', 'matchCost'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
}
