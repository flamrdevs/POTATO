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

class FarmerController extends BaseController
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
        return view('farmer.profile', ['user' => User::auth()]);
    }

    // ? GET
    // VIEW :: farmer.edit
    // halaman form ubah data petani
    public function edit()
    {
        return view('farmer.edit', ['user' => User::auth()]);
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
        
        $validator = $this->validateUpdateUser($request, $user);
        if ($validator->fails()) return redirect()->route('farmer.edit')->withErrors($validator)->withInput($request->all());

        if ($this->attemptUpdateUser($request, $user)) {
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
        if ($validator->fails()) return redirect()->route('farmer.password')->withErrors($validator)->withInput($request->all());

        if (!Hash::check($request->currentPassword, $user->password)) {
            Session::flash('failure','Password saat ini salah');
            return redirect()->route('farmer.password')->withErrors($validator)->withInput($request->all());
        }
        
        if ($this->attemptUpdatePassword($request, $user)) {
            Session::flash('success','Password berhasil diperbarui');
        } else {
            Session::flash('failure','Password gagal diperbarui');
        }

        return view('farmer.profile', compact('user'));
    }

    // ? SELF
    // VALIDATE ? User
    // function validasi update data petani kecuali password
    private function validateUpdateUser($request, $user)
    {
        return self::ext_ValidateUpdateUser($request, $user);
    }

    // ? SELF
    // VALIDATE ? User
    // function validasi update data petani hanya password
    private function validateUpdatePassword($request)
    {
        return self::ext_ValidateUpdatePassword($request);
    }

    // ? SELF
    // SAVE ? User
    // function update data petani kecuali password ke database
    private function attemptUpdateUser($request, $user)
    {
        return self::ext_AttemptUpdateUser($request, $user);
    }

    // ? SELF
    // SAVE ? User
    // function update data petani hanya password ke database
    private function attemptUpdatePassword($request, $user)
    {
        return self::ext_AttemptUpdatePassword($request, $user);
    }

    // *-----------------------------------------------------------------------
    // *     FARMER
    // *-----------------------------------------------------------------------

    // ? GET
    // VIEW :: farmer.farmer.index
    // halaman data petani
    public function farmer_index()
    {
        return view('farmer.farmer.index', ['farmers' => User::farmer(10)]);
    }

    // *-----------------------------------------------------------------------
    // *     SOIL MOISTURE
    // *-----------------------------------------------------------------------

    // ? GET
    // VIEW :: farmer.soilmoisture.index
    // halaman data kelembaban tanah
    public function soilmoisture_index()
    {
        return view('farmer.soilmoisture.index', ['soilmoistures' => SoilMoisture::paginate(20)]);
    }

    // ? GET
    // VIEW :: farmer.soilmoisture.show
    // halaman data kelembaban tanah berdasarkan id mesin
    public function soilmoisture_show($machine_id)
    {
        return view('farmer.soilmoisture.show', ['soilmoistures' => SoilMoisture::where('machine_id', $machine_id)->paginate(20)]);
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

        if (is_null($weather)) return redirect()->route('farmer.weather');

        $attributes = Weather::getAttributesFrom($weather);
        $humidity = Weather::getHumidityFrom($weather);
        $minHumidity = Weather::getMinHumidityFrom($weather);
        $maxHumidity = Weather::getMaxHumidityFrom($weather);
        $temperature = Weather::getTemperatureFrom($weather);
        $minTemperature = Weather::getMinTemperatureFrom($weather);
        $maxTemperature = Weather::getMaxTemperatureFrom($weather);

        return view('farmer.weather.index', compact(['attributes','humidity','minHumidity','maxHumidity','temperature','minTemperature','maxTemperature']));
    }
}
