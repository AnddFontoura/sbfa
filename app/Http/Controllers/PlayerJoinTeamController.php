<?php

namespace App\Http\Controllers;

use App\GamePosition;
use App\PlayerJoinTeam;
use App\Team;
use App\TeamHasPlayers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PlayerJoinTeamController extends Controller
{
    public function index(Request $request, int $teamId)
    {
        $this->validate($request, [
            'status' => 'nullable|int'
        ]);

        $filter = $request->all();

        $team = Team::where('id', $teamId)
            ->first();

        $playersRequests = PlayerJoinTeam::where('team_id', $teamId)
            ->orderBy('status', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('player_join_team.index', compact(
            'team',
            'playersRequests'
        ));
    }

    public function store(Request $request, int $teamId): RedirectResponse
    {
        $this->validate($request, [
            'ask_description' => 'nullable|string|max:1000'
        ]);

        $data = $request->except('_token');
        $askDescription = $data['ask_description'] ?? '';

        $canJoin = $this->teamService->checkIfTeamAllowNewPlayers($teamId);

        if($canJoin) {
            $userId = Auth::user()->id;

            $askedToJoin = $this->teamService->checkIfPlayerAlreadyAskToJoin($teamId, $userId);

            if (!$askedToJoin)
            {
                $this->teamService->registerInterestInTeam($teamId, $userId, $askDescription);
            } else {
                return back()->withErrors(['error' => 'Você já pediu para participar desse time.']);
            }
        }

        return back()->withErrors(['error' => 'O time não aceita novos jogadores no momento']);
    }

    public function acceptOrRejectRequest(Request $request, $requestId)
    {
        /**
         * TODO: precisa de uma validação pra ver se o usuario logado
         * pode ou não aceitar esse request
         */

        $playerJoinTeam = PlayerJoinTeam::where('id', $requestId)->first();
        $team = Team::where('id', $playerJoinTeam->team_id)->first();
        $teamHasPlayer = TeamHasPlayers::whereNull('user_id')->where('team_id', $playerJoinTeam->team_id)->get();
        $gamePositions = GamePosition::get();

        return view('player_join_team.form', compact('playerJoinTeam', 'team', 'teamHasPlayer', 'gamePositions'));
    }

    public function saveChangesOnAskToJoin(Request $request, int $requestId)
    {
        $this->validate($request, [
            'approveOrReject' => 'required|numeric',
            'approveOrRejectDescription' => 'nullable|string|max:1000',
            'teamHasPlayerId' => 'nullable|numeric',
            'userIsPlayer' => 'nullable|boolean',
            'userName' =>  'required|string|min:1|max:254',
            'userPhoto' => 'nullable|file|image',
            'userNickName' => 'nullable|string|min:1|max:254',
            'userWeight' => 'nullable|numeric',
            'userHeight' => 'nullable|numeric',
            'userBirthday' => 'nullable|date',
            'userDescription' => 'nullable|string|min:1|max:10000',
            'userPositions' => 'nullable|array'
        ]);

        $data = $request->except('_token');

        $playerJoinTeamRequest = PlayerJoinTeam::where('id', $requestId)
            ->update([
                'status' => $data['approveOrReject'],
                'response_description' => $data['approveOrRejectDescription'] ?? null
            ]);

        if ($data['approveOrReject'] == -1) {
            return redirect('players_joins_teams/' . $playerJoinTeamRequest->team_id)-with(['message' => 'Pedido rejeitado']);
        }

        if($data['teamHasPlayerId'] != 0) {
            $teamHasPlayer = TeamHasPlayers::where('team_id', $playerJoinTeamRequest->team_id)
                ->where('id', $playerJoinTeamRequest->id)
                ->update([
                    'user_id' => $playerJoinTeamRequest->user_id
                ]);
        } else {
            $picture = $data['profilePicture'] ?? null;
            unset($data['profilePicture']);

            $teamHasPlayer = TeamHasPlayers::create([
                'name' => $data['name'],
                'nickname' => $data['nickname'],
                'number' => $data['number'],
                'weight' => $data['weight'],
                'height' => $data['height'],
                'birthday' => $data['birthday'],
            ]);

            if ($request->file('profilePicture')) {
                $teamHasPlayer->profile_picture = $this->uploadService->uploadFileToFolder('public', 'teams_profiles_pictures', $picture);
                $teamHasPlayer->save();
            }
        }


    }

    public function edit(PlayerJoinTeam $playerJoinTeam)
    {
        //
    }

    public function update(Request $request, PlayerJoinTeam $playerJoinTeam)
    {
        //
    }

    public function destroy(PlayerJoinTeam $playerJoinTeam)
    {
        //
    }
}
