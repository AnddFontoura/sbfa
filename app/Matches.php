<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Matches extends Model
{
    use SoftDeletes;

    protected $table = "matches";
    
    protected $fillable = [
        'city_id',
        'home_team_id',
        'visitor_team_id',
        'visitor_team_name',
        'home_team_name',
        'visitor_score',
        'home_score',
        'match_datetime',
        'match_adress',
        'match_total_cost',
        'match_field_cost',
        'match_referees_cost',
        'extra_costs',
        'extra_costs_description',
    ];

    
    public function visitorTeam()
    {
        return $this->belongsTo(Team::class, 'visitor_team_id', 'id');
    }
    
    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
}
