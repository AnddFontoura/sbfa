<?php

namespace App\Http\Services;

use App\Team;
use Illuminate\Support\Facades\Auth;

class TeamService
{
    public function selectTeamsWithFilters(array $filter)
    {
        $teams = Team::select();

        if (isset($filter['teamName']) && $filter['teamName'] != "") {
            $teams->where('name', 'like', '%' . $filter['teamName'] . '%');
        }

        if (isset($filter['teamCity']) && $filter['teamCity'] != 0) {
            $teams->where('city_id', $filter['teamCity']);
        }

        if (isset($filter['teamState']) && $filter['teamState'] != 0) {
            $teams->join('cities', 'cities.id', '=', 'teams.city_id')
                ->where('state_id', $filter['teamState']);
        }

        if (isset($filter['myTeams']) && $filter['myTeams'] != "") {
            $user = Auth::user();
            $teams->where("owner_id", $user->id);
        }

        return $teams->paginate(20);
    }
}
