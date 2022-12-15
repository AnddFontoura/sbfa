<?php

namespace App\Http\Controllers;

use App\GamePosition;
use App\Team;
use App\TeamHasPlayers;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TeamHasPlayersController extends Controller
{
    protected function validation(Request $request)
    {
        return $this->validate($request, [
            'name' => 'required|string|min:1|max:200',
            'nickname' => 'nullable|string|min:1|max:200',
            'number' => 'nullable|integer|min:1|max:9999',
            'position_id' => 'nullable|integer',
        ]);
    }

    public function create(int $teamId, int $playerId = null)
    {
        $player = null;
        $gamePositions = GamePosition::get();
        $team = Team::where('id', $teamId)->first();

        if ($playerId) {
            $player = TeamHasPlayers::where('id', $playerId)->first();
        }

        return view('team_has_player.form', compact('team', 'player', 'gamePositions'));
    }

    /**
     * @param Request $request
     * @param int $teamId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request, int $teamId)
    {
        $this->permissionService->checkIfLoggedUserCanManageTeam($teamId);

        $this->validation($request);

        $data = $request->except(['_token']);
        $data['team_id'] = $teamId;
        $picture = $data['profilePicture'] ?? null;
        unset($data['profilePicture']);

        $teamHasPlayer = TeamHasPlayers::create($data);

        if ($request->file('profilePicture')) {
            $teamHasPlayer->profile_picture = $this->uploadService->uploadFileToFolder('public', 'teams_profiles_pictures', $picture);
            $teamHasPlayer->save();
        }

        return redirect('configuration/team/' . $teamId);
    }

    public function update(Request $request, int $teamId, int $playerId)
    {
        $this->permissionService->checkIfLoggedUserCanManageTeam($teamId);

        $this->validation($request);

        $data = $request->except(['_token', 'playerEmail']);
        $data['team_id'] = $teamId;

        if ($request->file('profilePicture')) {
            $data['profile_picture'] = $this->uploadService->uploadFileToFolder('public', 'teams_profiles_pictures', $data['profilePicture']);
        }

        unset($data['profilePicture']);

        TeamHasPlayers::where('id', $playerId)->update($data);

        return redirect('configuration/team/' . $teamId);
    }

    public function view(int $teamId, int $playerId)
    {
        $this->permissionService->checkIfLoggedUserCanManageTeam($teamId);

        $team = Team::where('id', $teamId)->first();
        $player = TeamHasPlayers::where('id', $playerId)->first();
        $player->age = Carbon::now()->diffInYears($player->birthday);

        return view('team_has_player.view' , compact('team', 'player'));
    }

    public function delete(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|int'
        ]);

        $playerId = $request->post('id');

        $teamPlayer = TeamHasPlayers::where('id', $playerId)->first();

        $this->permissionService->checkIfLoggedUserCanManageTeam($teamPlayer->team_id);

        $teamPlayer->delete();

        return response()->json('Jogador apagado do time com sucesso');
    }

}
