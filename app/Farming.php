<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Farming extends Model
{
    protected $fillable = [
        'start',
        'end',
        'status',
        'plant_id',
        'user_id',
        'machine_code'
    ];

    // * ------------------------------------------------
    // *    Methods
    // * ------------------------------------------------

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function plant()
    {
        return $this->belongsTo('App\Plant');
    }

    public function machine()
    {
        return $this->belongsTo('App\Machine', 'machine_code', 'code');
    }

    // Dapatkan Farming dengan status active dan join table users dan plants
    public static function activeWithUserPlantMachine()
    {
        return self::with(['user', 'plant', 'machine'])->where('status', true)->get();
    }

    // Dapatkan Farming dengan join table users dan plants
    public static function withUserPlantMachine()
    {
        return self::with(['user', 'plant', 'machine'])->latest()->get();
    }

    // Dapatkan satu Farming dengan join table users dan plants
    public static function withUserPlantMachineFind($id)
    {
        return self::with(['user', 'plant', 'machine'])->find($id);
    }

    // Dapatkan beberapa Farming dari user dengan join table users dan plants
    public static function withUserPlantMachineFindByUserId($id)
    {
        return self::with(['user', 'plant', 'machine'])->where('user_id', $id)->get();
    }
}
