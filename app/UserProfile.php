<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $table = "users_profiles";

    public $fillable = [
        'user_id',
        'is_player',
        'nickname',
        'photo',
        'weight',
        'height',
        'description',
        'birthdate',
        'game_positions',
    ];
}
