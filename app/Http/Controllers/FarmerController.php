<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\SoilMoisture;
use Illuminate\Support\Facades\Auth;
use Validator;
use Hash;
use Session;

class FarmerController extends Controller
{
    // Construct
    public function __construct()
    {
        $this->middleware(['auth','role:farmer']);
    }

    // 
    // HOME
    // 

    // view farmer home
    public function index()
    {
        return view('farmer.index');
    }

    // view farmer profile
    public function profile()
    {
        $user = User::find(Auth::user()->id);
        return view('farmer.profile', compact('user'));
    }

    // view edit data farmer
    public function edit()
    {
        $user = User::find(Auth::user()->id);
        return view('farmer.edit', compact('user'));
    }

    // view ubah password
    public function password(Request $request)
    {
        return view('farmer.password');
    }

    // api farmer update
    public function update(Request $request)
    {
        $user = User::find(Auth::user()->id);
        
        $validator = $this->validateUpdateUser($request);

        if ($validator->fails()) {
            return redirect()->route('farmer.edit')->withErrors($validator)->withInput($request->all());
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->birthDate = $request->birthDate;
        $user->gender = $request->gender;

        if ($user->save()) {
            Session::flash('success','Data berhasil diperbarui');
        } else {
            Session::flash('error','Data gagal diperbarui');
        }

        return view('farmer.profile', compact('user'));
    }

    // api farmer update password
    public function updatePassword(Request $request)
    {
        $user = User::find(Auth::user()->id);

        $validator = $this->validateUpdatePassword($request);

        if ($validator->fails()) {
            return redirect()->route('farmer.password')->withErrors($validator)->withInput($request->all());
        }

        if (Hash::check($request->currentPassword, $user->password)) {
            $user->password = Hash::make($request->password);
        } else {
            Session::flash('password','Password saat ini salah');
            return redirect()->route('farmer.password')->withErrors($validator)->withInput($request->all());
        }
        
        if ($user->save()) {
            Session::flash('success','Password berhasil diperbarui');
        } else {
            Session::flash('error','Password gagal diperbarui');
        }

        return view('farmer.profile', compact('user'));
    }

    // validasi update user
    private function validateUpdateUser($request)
    {
        return Validator::make($request->all(), [
            'name' => 'required|min:3|max:50',
            'email' => 'required|email|unique:users,email,'.Auth::user()->id,
        ], [
            'name.required' => 'Nama harus di isi',
            'email.required' => 'Email harus di isi',
            'email.unique' => 'Email sudah terdaftar',
        ]);
    }

    // validasi update password
    private function validateUpdatePassword($request)
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

    // 
    // FARMER
    // 

    // view table semua petani
    public function farmer_index()
    {
        $farmers = User::where('role','farmer')->paginate(10);
        return view('farmer.farmer.index', compact('farmers'));
    }

    // 
    // SOIL MOISTURE
    // 

    public function soilmoisture_index()
    {
        $soilmoistures = SoilMoisture::paginate(20);
        return view('farmer.soilmoisture.index', compact('soilmoistures'));
    }

    public function soilmoisture_show($machine_id)
    {
        $soilmoistures = SoilMoisture::where('machine_id', $machine_id)->paginate(20);
        return view('farmer.soilmoisture.show', compact('soilmoistures'));
    }

    // 
    // WEATHER
    // 

    // view cuaca
    public function weather_index()
    {
        $magetanId = '501289';
        // extends method from Controller::class
        $weather = $this->extend__weather_getArea($magetanId);
        if ($weather == null) {
            return redirect()->route('farmer.weather');
        }

        return view('farmer.weather.index', compact('weather'));
    }
}
