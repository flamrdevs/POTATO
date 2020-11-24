<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

// Framework
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'birthDate',
        'gender',
        'phone',
        'address',
        'role'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // * ------------------------------------------------
    // *    Methods
    // * ------------------------------------------------

    // Dapatkan User yang telah terautentikasi
    public static function auth()
    {
        return self::findOrFail(Auth::user()->id);
    }

    // Dapatkan User dengan role farmer dengan parameter paginate
    public static function farmer($paginate = false)
    {
        if (is_int($paginate)) {
            return self::where('role','farmer')->paginate($paginate);
        } else {
            return self::where('role','farmer')->get();
        }
    }
}
