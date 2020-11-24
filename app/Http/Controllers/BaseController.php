<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Framework
use Illuminate\Support\Facades\Auth;
use Validator;
use Hash;

// Model
use App\User;
use App\Broadcast;
use App\Farming;
use App\Plant;

class BaseController extends Controller
{

    ///___----------------___///
    ///.__ BaseController __.///
    ///..__________________..///

    // *-----------------------------------------------------------------------
    // *     USER
    // *-----------------------------------------------------------------------

    protected static function ext_ValidateCreateFarmer($request)
    {
        return Validator::make($request->all(), [
            'name' => 'required|min:3|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|min:8|same:password',
        ], [
            'name.required' => 'Nama harus di isi',
            'email.required' => 'Email harus di isi',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus di isi',
            'password_confirmation.required' => 'Konfirmasi password harus di isi',
            'password_confirmation.same' => 'Password konfirmasi tidak sama dengan password',
        ]);
    }

    protected static function ext_AttemptCreateFarmer($request)
    {
        return User::create([
            'name' => ucwords(strtolower($request->name)),
            'email' => strtolower($request->email),
            'password' => Hash::make($request->password),
            'birthDate' => $request->birthDate,
            'gender' => strtolower($request->gender),
            'phone' => strtolower($request->phone),
            'address' => $request->address,
            'role' => strtolower('farmer')
        ])->save();
    }

    protected static function ext_ValidateUpdateUser($request, $user)
    {
        return Validator::make($request->all(), [
            'name' => 'required|min:3|max:50',
            'email' => 'required|email|unique:users,email,'.$user->id,
        ], [
            'name.required' => 'Nama harus di isi',
            'email.required' => 'Email harus di isi',
            'email.unique' => 'Email sudah terdaftar',
        ]);
    }

    protected static function ext_ValidateUpdatePassword($request)
    {
        return Validator::make($request->all(), [
            'currentPassword' => 'required|min:8',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|min:8|same:password',
        ], [
            'currentPassword.required' => 'Password saat ini harus di isi',
            'currentPassword.min' => 'Password minimal berisi 8 karakter',
            'password.required' => 'Password baru harus di isi',
            'password.min' => 'Password minimal berisi 8 karakter',
            'password_confirmation.required' => 'Konfirmasi password harus di isi',
            'password_confirmation.min' => 'Password minimal berisi 8 karakter',
            'password_confirmation.same' => 'Password konfirmasi tidak sama dengan password',
        ]);
    }

    protected static function ext_AttemptUpdateUser($request, $user)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->birthDate = $request->birthDate;
        $user->gender = $request->gender;
        return $user->save();
    }

    protected static function ext_AttemptUpdatePassword($request, $user)
    {
        $user->password = Hash::make($request->password);
        return $user->save();
    }

    // *-----------------------------------------------------------------------
    // *     FARMING
    // *-----------------------------------------------------------------------

    protected static function ext_ValidateCreateFarming($request)
    {
        return Validator::make($request->all(), [
            'name' => 'required',
            'minHumidity' => 'required'
        ], [
            'name.required' => 'Pesan harus di isi',
            'minHumidity.required' => 'Data kelembaban minimal harus diisi'
        ]);
    }

    protected static function ext_AttemptCreateFarming($request)
    {
        return Farming::create([

        ])->save();
    }

    // *-----------------------------------------------------------------------
    // *     BROADCAST
    // *-----------------------------------------------------------------------

    protected static function ext_ValidateCreateUpdateBroadcast($request)
    {
        return Validator::make($request->all(), [
            'message' => 'required',
        ], [
            'message.required' => 'Pesan harus di isi',
        ]);
    }

    protected static function ext_AttemptCreateBroadcast($request)
    {
        return Broadcast::create([
            'message' => $request->message
        ])->save();
    }

    protected static function ext_AttemptUpdateBroadcast($request, $broadcast)
    {
        $broadcast->message = $request->message;
        return $broadcast->save();
    }
    
    // *-----------------------------------------------------------------------
    // *     PLANT
    // *-----------------------------------------------------------------------

    protected static function ext_ValidateCreateUpdatePlant($request)
    {
        return Validator::make($request->all(), [
            'name' => 'required',
            // 'minHumidity' => 'required'
        ], [
            'name.required' => 'Nama harus di isi',
            // 'minHumidity.required' => 'Data kelembaban minimal harus diisi'
        ]);
    }

    protected static function ext_AttemptCreatePlant($request)
    {
        return Plant::create([
            'name' => $request->name,
            'minHumidity' => 20.0
        ])->save();
    }

    protected static function ext_AttemptUpdatePlant($request, $plant)
    {
        $plant->name = $request->name;
        return $plant->save();
    }
}
