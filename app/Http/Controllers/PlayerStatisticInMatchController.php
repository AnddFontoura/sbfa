<?php

namespace App\Http\Controllers;

use App\GamePosition;
use App\Matches;
use App\MatchHasPlayer;
use App\PlayerStatisticInMatch;
use App\Statistic;
use App\Team;
use App\TeamHasPlayers;
use Illuminate\Http\Request;

class PlayerStatisticInMatchController extends Controller
{
    /**
     * @param int $teamId
     * @param int $matchId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(int $teamId, int $matchId)
    {
        $team = Team::where('id', $teamId)->first();
        $match = Matches::where('id', $matchId)->first();
        $matchHasPlayer = MatchHasPlayer::where('match_id', $matchId)
            ->join('teams_has_players', 'teams_has_players.id', '=', 'matches_has_players.team_has_player_id')
            ->where('teams_has_players.team_id', $teamId)
            ->where('matches_has_players.present', true)
            ->get();
        $statistics = Statistic::get();

        foreach($matchHasPlayer as $player) {
            $player->statistics = PlayerStatisticInMatch::where('team_has_player_id', $player->team_has_player_id)
                ->where('match_id', $matchId)
                ->get();
        }

        return view('player_statistic_in_match.form', compact('team', 'match', 'statistics', 'matchHasPlayer'));
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

    /**
     * Display the specified resource.
     *
     * @param  \App\PlayerStatisticInMatch  $playerStatisticInMatch
     * @return \Illuminate\Http\Response
     */
    public function show(PlayerStatisticInMatch $playerStatisticInMatch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PlayerStatisticInMatch  $playerStatisticInMatch
     * @return \Illuminate\Http\Response
     */
    public function edit(PlayerStatisticInMatch $playerStatisticInMatch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PlayerStatisticInMatch  $playerStatisticInMatch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PlayerStatisticInMatch $playerStatisticInMatch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PlayerStatisticInMatch  $playerStatisticInMatch
     * @return \Illuminate\Http\Response
     */
    public function destroy(PlayerStatisticInMatch $playerStatisticInMatch)
    {
        //
    }
}
