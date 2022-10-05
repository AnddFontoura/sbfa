<?php

namespace App\Http\Controllers;

use App\GamePosition;
use App\Team;
use App\TeamHasPlayers;
use Illuminate\Http\Request;

class TeamHasPlayersController extends Controller
{
    
    protected $model;
    protected $viewFolder;
    protected $multipleRecordName;
    protected $singleRecordName;
    protected $teamModel;
    protected $gamePositionsModel;
    
    function __construct()
    {
        $this->teamModel = new Team();
        $this->model = new TeamHasPlayers();
        $this->gamePositionsModel = new GamePosition();
        $this->viewFolder = "team_has_player";
        $this->singleRecordName = "teamHasPlayer";
        $this->multipleRecordName = "teamHasPlayers";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request, int $teamId, ?int $playerId = null)
    {
        $player = null;
        $gamePositions = $this->gamePositionsModel::get();
        ${$this->multipleRecordName} = $this->model::where('team_id', $teamId)->get();
        $team = $this->teamModel::where('id', $teamId)->first();
        
        if($playerId) {
            $player = $this->model::where('id', $playerId)->where('team_id', $teamId)->first();
        }

        return view($this->viewFolder . '.index', compact($this->multipleRecordName, 'team', 'player', 'gamePositions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(int $teamId, ?int $playerId = null)
    {
        $player = null;
        $team = $this->teamModel::where('id', $teamId)->first();
        $gamePositions = $this->gamePositionsModel::get();


        return view($this->viewFolder . '.form', compact('team', 'player', 'gamePositions'));
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
            $this->model::where('id', $playerId)->update($data);
        } else {
            $this->model::create($data);
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
