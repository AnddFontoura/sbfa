<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MatchHasPlayer extends Model
{
    use SoftDeletes;

    protected $table = "matches_has_players";

    public $fillable = [
        'match_id',
        'team_has_player_id',
        'game_position_id',
        'number_used',
        'payed',
        'present',
        'match_notes',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function match(): BelongsTo
    {
        return $this->belongsTo(Matches::class, 'match_id', 'id');
    }

    public function teamHasPlayer(): BelongsTo
    {
        return $this->belongsTo(TeamHasPlayers::class, 'team_has_player_id', 'id');
    }

    public function gamePosition(): BelongsTo
    {
        return $this->belongsTo(GamePosition::class, 'game_position_id', 'id');
    }
}
