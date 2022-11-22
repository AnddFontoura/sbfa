<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Statistic extends Model
{
    use SoftDeletes;

    protected $table = 'statistics';

    protected $fillable = [
        'name',
        'description',
    ];
}
