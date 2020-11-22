<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

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

    ///____      ____///
    ///___ METHOD ___///
    ///____      ____///

    // Dapatkan pengguna yang telah terautentikasi
    public static function auth()
    {
        return User::find(Auth::user()->id);
    }

    // Dapatkan pengguna dengan role adalah farmer dengan parameter paginate
    public static function farmer($paginate = false)
    {
        if (is_int($paginate)) {
            return User::where('role','farmer')->paginate($paginate);
        } else {
            return User::where('role','farmer')->get();
        }
    }
}
