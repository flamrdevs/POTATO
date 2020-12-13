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
use App\Machine;

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
            'name' => 'required|max:63',
            'email' => 'required|email|max:63|unique:users,email',
            'password' => 'required|min:8|max:63',
            'password_confirmation' => 'required|min:8|same:password',
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'name.max' => 'Nama terlalu panjang',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'email.max' => 'Email terlalu panjang',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password terlalu pendek',
            'password.max' => 'Password terlalu panjang',
            'password_confirmation.required' => 'Konfirmasi password tidak boleh kosong',
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
            'name' => 'required|max:63',
            'email' => 'required|email|max:63|unique:users,email,'.$user->id,
            'phone' => 'max:63',
            'address' => 'max:63'
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'name.max' => 'Nama terlalu panjang',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'email.max' => 'Email terlalu panjang',
            'phone.max' => 'No Telepon terlalu panjang',
            'address.max' => 'Alamat terlalu panjang',
        ]);
    }

    protected static function ext_ValidateUpdatePassword($request)
    {
        return Validator::make($request->all(), [
            'currentPassword' => 'required|min:8|max:63',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|min:8|same:password',
        ], [
            'currentPassword.required' => 'Password saat ini tidak boleh kosong',
            'currentPassword.min' => 'Password minimal berisi 8 karakter',
            'currentPassword.max' => 'Password terlalu panjang',
            'password.required' => 'Password baru tidak boleh kosong',
            'password.min' => 'Password minimal berisi 8 karakter',
            'password_confirmation.required' => 'Konfirmasi password tidak boleh kosong',
            'password_confirmation.min' => 'Password minimal berisi 8 karakter',
            'password_confirmation.same' => 'Konfirmasi password tidak sama dengan password saat ini',
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

    protected static function ext_ValidateCreateUpdateFarming($request)
    {
        return Validator::make($request->all(), [
            'farmer' => 'required',
            'plant' => 'required'
        ], [
            'farmer.required' => 'Petani tidak boleh kosong',
            'plant.required' => 'Tanaman tidak boleh kosong'
        ]);
    }

    protected static function ext_AttemptCreateFarming($request)
    {
        return Farming::create([
            'user_id' => $request->farmer,
            'plant_id' => $request->plant,
            'machine_code' => $request->machine
        ])->save();
    }

    protected static function ext_AttemptUpdateFarming($request, $farming)
    {
        if ($request->status) {
            $farming->status = false;
            $farming->end = now();
            return $farming->save();
        }

        $farming->user_id = $request->farmer;
        $farming->plant_id = $request->plant;
        $farming->machine_code = is_null($request->machine) ? null : $request->machine;
        return $farming->save();
    }

    // *-----------------------------------------------------------------------
    // *     BROADCAST
    // *-----------------------------------------------------------------------

    protected static function ext_ValidateCreateUpdateBroadcast($request)
    {
        return Validator::make($request->all(), [
            'message' => 'required|max:511|',
        ], [
            'message.required' => 'Pesan tidak boleh kosong',
            'message.max' => 'Pesan terlalu panjang',
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
            'name' => 'required|max:63',
            'minHumidity' => 'required'
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'name.max' => 'Nama terlalu panjang',
            'minHumidity.required' => 'Data kelembaban minimal tidak boleh kosong'
        ]);
    }

    protected static function ext_AttemptCreatePlant($request)
    {
        return Plant::create([
            'name' => $request->name,
            'minHumidity' => $request->minHumidity
        ])->save();
    }

    protected static function ext_AttemptUpdatePlant($request, $plant)
    {
        $plant->name = $request->name;
        $plant->minHumidity = $request->minHumidity;
        return $plant->save();
    }

    // *-----------------------------------------------------------------------
    // *     MACHINE
    // *-----------------------------------------------------------------------

    protected static function ext_ValidateCreateUpdateMachine($request)
    {
        return Validator::make($request->all(), [
            'code' => 'required|max:63',
        ], [
            'code.required' => 'Kode tidak boleh kosong',
            'code.max' => 'Kode terlalu panjang'
        ]);
    }

    protected static function ext_AttemptCreateMachine($request)
    {
        return Machine::create([
            'code' => $request->code
        ])->save();
    }
}
