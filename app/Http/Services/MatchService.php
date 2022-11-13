<?php

namespace App\Http\Services;

use App\Matches;
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
}
