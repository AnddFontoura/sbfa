<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlayerInvited extends Model
{
    use SoftDeletes;

    protected $table = "players_invited";

    public $fillable = [
        'team_has_player_id',
        'email',
    ];

    public function teamHasPlayer(): BelongsTo
    {
        return $this->belongsTo(TeamHasPlayers::class, 'team_has_player_id', 'id');
    }
}
