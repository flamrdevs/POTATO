<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Framework
use Validator;
use Hash;
use Session;

// Model
use App\User;
use App\SoilMoisture;
use App\Broadcast;
use App\Farming;
use App\Plant;
use App\Weather;

class FarmerController extends Controller
{

    ///___------------------___///
    ///.__ FarmerController __.///
    ///..____________________..///

    // *-----------------------------------------------------------------------
    // *     HOME
    // *-----------------------------------------------------------------------

    // ? GET
    // VIEW :: farmer.index
    // halaman home petani
    public function index()
    {
        return view('farmer.index');
    }

    // ? GET
    // VIEW :: farmer.profile
    // halaman profile petani
    public function profile()
    {
        $user = User::auth();
        return view('farmer.profile', compact('user'));
    }

    // ? GET
    // VIEW :: farmer.edit
    // halaman form ubah data petani
    public function edit()
    {
        $user = User::auth();
        return view('farmer.edit', compact('user'));
    }

    // ? GET
    // VIEW :: farmer.password
    // halaman form ubah password petani
    public function password(Request $request)
    {
        return view('farmer.password');
    }

    // ? PUT
    // ENDPOINT :: User update
    // api untuk update data petani kecuali password
    public function update(Request $request)
    {
        $user = User::auth();
        
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
            Session::flash('failure','Data gagal diperbarui');
        }

        return view('farmer.profile', compact('user'));
    }

    // ? PUT
    // ENDPOINT :: User update
    // api untuk update data petani hanya password
    public function updatePassword(Request $request)
    {
        $user = User::auth();

        $validator = $this->validateUpdatePassword($request);

        if ($validator->fails()) {
            return redirect()->route('farmer.password')->withErrors($validator)->withInput($request->all());
        }

        if (Hash::check($request->currentPassword, $user->password)) {
            $user->password = Hash::make($request->password);
        } else {
            Session::flash('failure','Password saat ini salah');
            return redirect()->route('farmer.password')->withErrors($validator)->withInput($request->all());
        }
        
        if ($user->save()) {
            Session::flash('success','Password berhasil diperbarui');
        } else {
            Session::flash('failure','Password gagal diperbarui');
        }

        return view('farmer.profile', compact('user'));
    }

    // ? SELF
    // VALIDATE ? User
    // function validasi update data petani kecuali password
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

    // ? SELF
    // VALIDATE ? User
    // function validasi update data petani hanya password
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

    // *-----------------------------------------------------------------------
    // *     FARMER
    // *-----------------------------------------------------------------------

    // ? GET
    // VIEW :: farmer.farmer.index
    // halaman data petani
    public function farmer_index()
    {
        $farmers = User::farmer(10);
        return view('farmer.farmer.index', compact('farmers'));
    }

    // *-----------------------------------------------------------------------
    // *     SOIL MOISTURE
    // *-----------------------------------------------------------------------

    // ? GET
    // VIEW :: farmer.soilmoisture.index
    // halaman data kelembaban tanah
    public function soilmoisture_index()
    {
        $soilmoistures = SoilMoisture::paginate(20);
        return view('farmer.soilmoisture.index', compact('soilmoistures'));
    }

    // ? GET
    // VIEW :: farmer.soilmoisture.show
    // halaman data kelembaban tanah berdasarkan id mesin
    public function soilmoisture_show($machine_id)
    {
        $soilmoistures = SoilMoisture::where('machine_id', $machine_id)->paginate(20);
        return view('farmer.soilmoisture.show', compact('soilmoistures'));
    }

    // *-----------------------------------------------------------------------
    // *     WEATHER
    // *-----------------------------------------------------------------------

    // ? GET
    // VIEW :: farmer.weather.index
    // halaman data cuaca (hari ini)
    public function weather_index()
    {
        $magetanId = '501289';
        $weather = Weather::area($magetanId);

        if (is_null($weather)) {
            return redirect()->route('farmer.weather');
        }

        $attributes = $weather['attributes'];
        $humidity = $weather['humidity'];
        $minHumidity = $weather['minHumidity']['timerange'][0]['value'];
        $maxHumidity = $weather['maxHumidity']['timerange'][0]['value'];
        $temperature = $weather['temperature'];
        $minTemperature = $weather['minTemperature']['timerange'][0]['value'][0];
        $maxTemperature = $weather['maxTemperature']['timerange'][0]['value'][0];

        return view('farmer.weather.index', compact(['attributes','humidity','minHumidity','maxHumidity','temperature','minTemperature','maxTemperature']));
    }
}
