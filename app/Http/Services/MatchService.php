<?php

namespace App\Http\Services;

use App\MatchCost;
use App\Matches;
use App\MatchHasPlayer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class MatchService {

    /**
     * @param int $teamId
     * @param int $limit
     * @return Model
     */
    public function getMatchOfTeam(int $teamId, int $limit = 0): Builder
    {
        $matches = Matches::where('home_team_id', $teamId)
            ->orWhere('visitor_team_id', $teamId);

        if ($limit > 0) {
            $matches = $matches->limit($limit);
        }

        $matches = $matches->orderBy('match_datetime', 'desc');

        return $matches;
    }

    public function getCashSpentFromMatches(int $teamId)
    {
        return MatchCost::sum('match_total_cost')
            ->where('team_id', $teamId)
            ->first();
    }

    public function getCashEarnedFromPlayers(int $teamId)
    {
        return MatchHasPlayer::sum('match_has_player.payed')
            ->join('match', 'match.id', '=', 'match_has_player.match_id')
            ->where('match.team_id', $teamId)
            ->first();
    }
}
