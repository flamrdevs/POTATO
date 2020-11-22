<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SoilMoisture extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'machine_id',
        'value'
    ];
}
