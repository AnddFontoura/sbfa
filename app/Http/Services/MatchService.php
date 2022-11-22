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
        return MatchCost::where('team_id', $teamId)
            ->sum('match_total_cost');
    }

    public function getCashEarnedFromPlayers(int $teamId)
    {
        $asVisitor = MatchHasPlayer::join('matches', 'matches.visitor_team_id', '=', 'matches_has_players.match_id')
        ->where('matches.visitor_team_id', $teamId)
        ->sum('matches_has_players.payed');

        $asHome = MatchHasPlayer::join('matches', 'matches.home_team_id', '=', 'matches_has_players.match_id')
        ->where('matches.home_team_id', $teamId)
        ->sum('matches_has_players.payed');
        
        return $asHome + $asVisitor;
    }
}
