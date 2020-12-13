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

    // * ------------------------------------------------
    // *    Methods
    // * ------------------------------------------------
    
    public static function findByFarmingIdPaginate($id, $paginate = 10)
    {
        return self::where('farming_id', $id)->orderBy('start', 'DESC')->paginate($paginate);
    }
}
