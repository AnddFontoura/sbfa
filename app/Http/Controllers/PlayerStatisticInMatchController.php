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
            $playerStatistics = PlayerStatisticInMatch::where('team_has_player_id', $player->team_has_player_id)
                ->where('match_id', $matchId)
                ->get();

            $playerStatisticArray = [];

            foreach($playerStatistics as $playerStatistic) {
                $playerStatisticArray[$playerStatistic->statistic_id] = $playerStatistic->value;
            }

            $player->statistics = $playerStatisticArray;
        }

        return view('player_statistic_in_match.form', compact('team', 'match', 'statistics', 'matchHasPlayer'));
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

        $data = $request->except('_token');

        foreach ($data['player'] as $playerId => $playerInfo) {
            foreach($playerInfo as $statisticId => $statisticData) {
                $playerStatisticInMatch = PlayerStatisticInMatch::where('team_has_player_id', $playerId)
                    ->where('statistic_id', $statisticId)
                    ->first();

                if($playerStatisticInMatch) {
                    $playerStatisticInMatch->value = $statisticData;
                    $playerStatisticInMatch->save();
                } else {
                    PlayerStatisticInMatch::create([
                        'team_has_player_id' => $playerId,
                        'match_id' => $matchId,
                        'statistic_id' => $statisticId,
                        'value' => $statisticData
                    ]);
                }
            }
        }

        return redirect('matches/statistics/' .$teamId . '/' . $matchId);
    }
}
