<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MatchCost extends Model
{
    use SoftDeletes;

    protected $table = "matches_costs";

    protected $fillable = [
        'team_id',
        'match_id',
        'match_total_cost',
        'match_field_cost',
        'match_referees_cost',
        'extra_costs',
        'extra_costs_description',
    ];
}
