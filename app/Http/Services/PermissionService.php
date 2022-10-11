<?php

namespace App\Http\Services;

use App\PlayerInvited;
use App\Team;
use Exception;
use Illuminate\Support\Facades\Auth;

class PermissionService {
    
    protected $loggedUserId;
    protected $loggedUserEmail;

    public function checkIfLoggedUserCanManageTeam(int $teamId)
    {
        $this->loggedUserId = Auth::id();
        $this->loggedUserEmail = Auth::user();
        
        $team = Team::where('id', $teamId)->first();

        if ($team->owner_id != $this->loggedUserId) {
            abort(404);
        }
    }

    public function checkIfLoggedUserCanAcceptOrDeclineInvitation(int $playerInvitedId) 
    {
        $this->loggedUserId = Auth::id();
        $this->loggedUserEmail = Auth::user()->email;

        $playerInvited = PlayerInvited::where('id', $playerInvitedId)->first();

        throw_if($playerInvited->email != $this->loggedUserEmail, new Exception(
            'Usuário não autorizado a fazer essa operação',
            404
        ));
        
        return $playerInvited;
    }
}