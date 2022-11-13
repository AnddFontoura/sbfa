<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlayerStatisticInMatch extends Model
{
    use SoftDeletes;

    protected $table = "players_statistics_in_matches";

    protected $fillable = [
        'team_has_player_id',
        'match_id',
        'statistic_id',
        'value',
    ];

    public function teamHasPlayer(): HasOne
    {
        return $this->hasOne(TeamHasPlayers::class, 'id', 'team_has_player_id');
    }

    public function match(): HasOne
    {
        return $this->hasOne(Matches::class, 'id', 'match_id');
    }

    public function statistics(): HasOne
    {
        return $this->hasOne(Statistic::class, 'id', 'statistic_id');
    }
}
