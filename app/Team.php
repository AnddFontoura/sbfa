<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'owner_id',
        'city_id',
        'name',
        'description',
        'logo',
        'header',
    ];
    
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }
    
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
}
