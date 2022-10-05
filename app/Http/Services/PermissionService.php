<?php

namespace App\Http\Services;

use App\Team;
use Illuminate\Support\Facades\Auth;

class PermissionService {
    public function checkIfLoggedUserCanManageTeam(?int $teamId)
    {
        $userId = Auth::id();
        $team = Team::where('id', $teamId)->first();

        if ($team->owner_id == $userId) {
            abort(404);
        }
    }
}