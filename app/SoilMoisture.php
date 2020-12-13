<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SoilMoisture extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'machine_id',
        'value',
        'farming_id'
    ];

    // * ------------------------------------------------
    // *    Methods
    // * ------------------------------------------------
    
    public static function findByFarmingIdPaginate($id, $paginate = 10)
    {
        return self::where('farming_id', $id)->orderBy('timestamp', 'DESC')->paginate($paginate);
    }
}
