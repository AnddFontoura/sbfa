<?php

namespace App\Http\Controllers;

use App\GamePosition;
use App\Matches;
use App\MatchHasPlayer;
use App\Statistic;
use App\Team;
use App\TeamHasPlayers;
use Illuminate\Http\Request;

class MatchHasPlayerController extends Controller
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
        $teamHasPlayers = TeamHasPlayers::where('team_id', $teamId)->get();
        $gamePositions = GamePosition::get();

        foreach ($teamHasPlayers as $teamHasPlayer) {
            $matchHasPlayer = MatchHasPlayer::where('team_has_player_id', $teamHasPlayer->id)
                ->where('match_id', $matchId)
                ->first();

            $teamHasPlayer->matchHasPlayer = $matchHasPlayer;
        }

        return view('match_has_player.assign_player_to_match', compact('team', 'match', 'gamePositions', 'teamHasPlayers'));
    }

    /**
     * @param Request $request
     * @param int $teamId
     * @param int $matchId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, int $teamId, int $matchId)
    {
        $this->validate($request, [
            'player' => 'required|array'
        ]);

        $players = $request->only('player');

        foreach ($players['player'] as $key => $player) {
            $matchHasPlayer = MatchHasPlayer::where('match_id', $matchId)
                ->where('team_has_player_id', $key)
                ->first();

            if (!$matchHasPlayer) {
                MatchHasPlayer::create([
                    'match_id' => $matchId,
                    'team_has_player_id' => $key,
                    'game_position_id' => $player['position_id'],
                    'number_used' => $player['number'],
                    'payed' => $player['payed'],
                    'present' => $player['present'] == 1 ?? 0,
                    'match_notes' => $player['match_notes'],
                ]);
            } else {
                MatchHasPlayer::where('team_has_player_id', $key)
                    ->update([
                        'match_id' => $matchId,
                        'game_position_id' => $player['position_id'],
                        'number_used' => $player['number'],
                        'payed' => $player['payed'],
                        'present' => $player['present'] == '1' ?? 0,
                        'match_notes' => $player['match_notes'],
                    ]);
            }
        }

        return redirect("matches/players-at-match/$teamId/$matchId");
    }
}
