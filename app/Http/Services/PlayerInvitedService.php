<?php

namespace App\Http\Services;

use App\Mail\PlayerInvitedMail;
use App\PlayerInvited;
use App\TeamHasPlayers;
use App\User;
use Illuminate\Support\Facades\Mail;

class PlayerInvitedService {

    /**
     * @param string $email
     * @param int $teamHasPlayerId
     * @return void
     */
    public function registerPlayerInvitation(string $email, int $teamHasPlayerId)
    {
        $alreadyAtTeam = PlayerInvited::where('email', $email)
            ->where('team_has_player_id', $teamHasPlayerId)
            ->first();

        if (!$alreadyAtTeam) {
            PlayerInvited::create([
                'team_has_player_id' => $teamHasPlayerId,
                'email' => $email,
            ]);
        }

        $teamPlayer = TeamHasPlayers::where('id', $teamHasPlayerId)->first();
        $fakeUser = (new User(['email' => $email, 'name' => $teamPlayer->name]));

        Mail::to($fakeUser)->send(new PlayerInvitedMail($email, $teamPlayer->name));
    }
}
