<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserProfile extends Model
{
    protected $table = "users_profiles";

    public $fillable = [
        'user_id',
        'city_id',
        'is_player',
        'nickname',
        'photo',
        'mobile_number',
        'weight',
        'height',
        'description',
        'birthdate',
        'game_positions',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function city(): HasOne
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }
}
