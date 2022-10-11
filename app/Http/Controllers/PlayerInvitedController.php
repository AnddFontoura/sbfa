<?php

namespace App\Http\Controllers;

use App\PlayerInvited;
use App\TeamHasPlayers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlayerInvitedController extends Controller
{
    public function invite(Request $request) 
    {
        $this->validate($request, [
            'team_has_player_id' => 'required|int',
            'email' => 'required|email'
        ]);

        $data = $request->except('_token');
        $teamHasPlayerId = $request->post('team_has_player_id');
        $teamHasPlayer = TeamHasPlayers::where('id', $teamHasPlayerId)->first();

        $this->permissionService->checkIfLoggedUserCanManageTeam($teamHasPlayer->team_id);
        $this->playerInvitedService->registerPlayerInvitation($data['email'], $data['team_has_player_id']);

        return response()->json('Jogador Convidado');
    }

    public function yes(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer'
        ]);

        $inviteId = $request->post('id');

        $playerInvited = $this->permissionService->checkIfLoggedUserCanAcceptOrDeclineInvitation($inviteId);
        $userId = Auth::id();

        $teamHasPlayer = TeamHasPlayers::where('id', $playerInvited->team_has_player_id)->first();
        $teamHasPlayer->user_id = $userId;
        $teamHasPlayer->save();

        $playerInvited->delete();

        return response()->json(['success' => 'Aceito com sucesso']);
    }

    public function no(Request $request) 
    {
        $this->validate($request, [
            'id' => 'required|integer'
        ]);

        $inviteId = $request->post('id');
    
        $playerInvited = $this->permissionService->checkIfLoggedUserCanAcceptOrDeclineInvitation($inviteId);
        
        $teamHasPlayer = TeamHasPlayers::where('id', $playerInvited->team_has_player_id)->first();    
        $playerInvited->delete();

        return response()->json(['success' => 'Recusado com sucesso']);
    }
}
