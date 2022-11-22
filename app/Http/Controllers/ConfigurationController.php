<?php

namespace App\Http\Controllers;

use App\GamePosition;
use App\Team;
use App\TeamHasPlayers;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    public function team(int $teamId)
    {
        $this->permissionService->checkIfLoggedUserCanManageTeam($teamId);
        
        $player = null;
        $team = Team::where('id', $teamId)->first();
        $teamHasPlayers = TeamHasPlayers::where('team_id', $teamId)->orderBy('active', 'asc')->get();
        $gamePositions = GamePosition::get();
        $lastMatches = $this->matchService->getMatchOfTeam($teamId, 5)->get();

        return view('configuration.team_dashboard', compact('team', 'teamHasPlayers', 'player', 'gamePositions', 'lastMatches'));
    }
}
