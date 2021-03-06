<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    protected $primaryKey = 'code';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'code',
        'status'
    ];

    // * ------------------------------------------------
    // *    Methods
    // * ------------------------------------------------

    public function farming()
    {
        return $this->hasOne('App\Farming');
    }

    // Dapatkan Machine dengan status ready
    public static function ready()
    {
        return self::where('status', 'ready')->get();
    }

    // Dapatkan Machine dengan status used
    public static function used()
    {
        return self::where('status', 'used')->get();
    }

    // Perbarui status Machine menjadi ready
    public static function statusToReady($code)
    {
        $machine = self::findOrFail($code);
        $machine->status = 'ready';
        $machine->save();
    }

    // Perbarui status Machine menjadi used
    public static function statusToUsed($code)
    {
        $machine = self::findOrFail($code);
        $machine->status = 'used';
        $machine->save();
    }
}
