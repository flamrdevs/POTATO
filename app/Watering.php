<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Watering extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'start',
        'end',
        'farming_id'
    ];
}
