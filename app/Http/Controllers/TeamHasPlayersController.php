<?php

namespace App\Http\Controllers;

use App\GamePosition;
use App\Team;
use App\TeamHasPlayers;
use Illuminate\Http\Request;

class TeamHasPlayersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, int $teamId, ?int $playerId = null)
    {
        $player = null;
        $gamePositions = GamePosition::get();
        $teamHasPlayers = TeamHasPlayers::where('team_id', $teamId)->get();
        $team = Team::where('id', $teamId)->first();
        
        if($playerId) {
            $player = $this->model::where('id', $playerId)->where('team_id', $teamId)->first();
        }

        return view('team_has_player.index', compact('teamHasPlayers', 'team', 'player', 'gamePositions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(int $teamId, ?int $playerId = null)
    {
        $player = null;
        $team = Team::where('id', $teamId)->first();
        $gamePositions = GamePosition::get();

        return view('team_has_player.form', compact('team', 'player', 'gamePositions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $teamId, ?int $playerId = null)
    {
        $this->validate($request, [
            'name' => 'required|string|min:1|max:200',
            'nickname' => 'nullable|string|min:1|max:200',
            'number' => 'nullable|integer|min:1|max:9999',
            'position_id' => 'nullable|integer', 
        ]);

        $data = $request->except('_token');
        $data['team_id'] = $teamId;

        if ($playerId) {
            TeamHasPlayers::where('id', $playerId)->update($data);
        } else {
            TeamHasPlayers::create($data);
        }

        return redirect('teams-has-players/team/' . $teamId);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TeamHasPlayers  $teamHasPlayers
     * @return \Illuminate\Http\Response
     */
    public function show(TeamHasPlayers $teamHasPlayers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TeamHasPlayers  $teamHasPlayers
     * @return \Illuminate\Http\Response
     */
    public function edit(TeamHasPlayers $teamHasPlayers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TeamHasPlayers  $teamHasPlayers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TeamHasPlayers $teamHasPlayers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TeamHasPlayers  $teamHasPlayers
     * @return \Illuminate\Http\Response
     */
    public function destroy(TeamHasPlayers $teamHasPlayers)
    {
        //
    }
}
