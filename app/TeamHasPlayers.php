<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeamHasPlayers extends Model
{
    use SoftDeletes;

    protected $table = "teams_has_players";

    protected $fillable = [
        'team_id',
        'user_id',
        'position_id',
        'profile_picture',
        'name',
        'nickname',
        'number',
        'weight',
        'height',
        'birthday',
        'active',
        'inactive_reason',
    ];

    public function player(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(GamePosition::class, 'position_id', 'id');
    }

}
