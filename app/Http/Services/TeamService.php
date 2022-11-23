<?php

namespace App\Http\Services;

use App\Team;

class TeamService
{
    public function selectTeamsWithFilters(array $filter)
    {
        $teams = Team::select();

        if (isset($filter['teamName']) && $filter['teamName'] != "") {
            $teams->where('name', '%' . $filter['teamName'] . '%');
        }

        if (isset($filter['teamCity']) && $filter['teamCity'] != 0) {
            $teams->where('city_id', $filter['teamCity']);
        }

        if (isset($filter['teamState']) && $filter['teamState'] != 0) {
            $teams->join('cities', 'cities.id', '=', 'teams.city_id')
                ->where('state_id', $filter['teamState']);
        }

        return $teams->paginate(20);
    }
}
