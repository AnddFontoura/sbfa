<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeamHasPlayers extends Model
{
    use SoftDeletes;

    protected $table = "teams_has_players";

    protected $fillable = [
        'team_id',
        'user_id',
        'position_id',
        'name',
        'nickname',
        'number',
    ];

    public function player()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }

    public function position()
    {
        return $this->belongsTo(GamePosition::class, 'position_id', 'id');
    }
}
