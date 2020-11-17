<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    protected $fillable = [
        'idArea', 'attributes', 'humidity', 'minHumidity', 'maxHumidity', 'temperature', 'minTemperature', 'maxTemperature', 'weather'
    ];
}
