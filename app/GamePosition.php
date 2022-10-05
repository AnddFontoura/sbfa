<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GamePosition extends Model
{
    use SoftDeletes;

    protected $table = 'game_positions';
    
    public $fillable = [
        'name',
        'short',
        'description',
        'icon'
    ];
}
