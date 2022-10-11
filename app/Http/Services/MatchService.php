<?php

namespace App\Http\Services;

use App\Matches;
use App\PlayerInvited;
use App\Team;
use Exception;
use Illuminate\Support\Facades\Auth;

class MatchService {
    public function getMatchOfTeam(int $teamId, int $limit = 0)
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