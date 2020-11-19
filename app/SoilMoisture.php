<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SoilMoisture extends Model
{
    protected $fillable = [
        'machine_id', 'value'
    ];
}
