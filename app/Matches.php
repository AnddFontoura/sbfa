<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Matches extends Model
{
    use SoftDeletes;

    protected $table = "matches";

    protected $fillable = [
        'city_id',
        'created_by_team_id',
        'home_team_id',
        'visitor_team_id',
        'visitor_team_name',
        'home_team_name',
        'visitor_score',
        'home_score',
        'match_datetime',
        'match_address',
        'show_home_profile',
        'show_visitor_profile',
    ];

    public $dates = [
        'match_datetime',
    ];

    public function visitorTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'visitor_team_id', 'id');
    }

    public function homeTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'home_team_id', 'id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
}
