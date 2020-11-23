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

class AdminController extends BaseController
{

    ///___-----------------___///
    ///.__ AdminController __.///
    ///..___________________..///

    // *-----------------------------------------------------------------------
    // *     HOME
    // *-----------------------------------------------------------------------

    // ? GET
    // VIEW :: admin.index
    // halaman home admin
    public function index()
    {
        return view('admin.index');
    }

    // ? GET
    // VIEW :: admin.profile
    // halaman profile admin
    public function profile()
    {
        return view('admin.profile', ['user' => User::auth()]);
    }

    // ? GET
    // VIEW :: admin.edit
    // halaman form ubah data admin
    public function edit()
    {
        return view('admin.edit', ['user' => User::auth()]);
    }

    // ? GET
    // VIEW :: admin.password
    // halaman form ubah password admin
    public function password()
    {
        return view('admin.password');
    }

    // ? PUT
    // ENDPOINT :: User update
    // api untuk update data admin kecuali password
    public function update(Request $request)
    {
        $user = User::auth();
        
        $validator = $this->validateUpdateUser($request);
        if ($validator->fails()) return redirect()->route('admin.edit')->withErrors($validator)->withInput($request->all());

        if ($this->attemptUpdateUser($request, $user)) {
            Session::flash('success','Data berhasil diperbarui');
        } else {
            Session::flash('failure','Data gagal diperbarui');
        }

        return view('admin.profile', compact('user'));
    }

    // ? PUT
    // ENDPOINT :: User update
    // api untuk update data admin hanya password
    public function updatePassword(Request $request)
    {
        $user = User::auth();

        $validator = $this->validateUpdatePassword($request);
        if ($validator->fails()) return redirect()->route('admin.password')->withErrors($validator)->withInput($request->all());

        if (!Hash::check($request->currentPassword, $user->password)) {
            Session::flash('failure','Password saat ini salah');
            return redirect()->route('admin.password')->withErrors($validator)->withInput($request->all());
        }

        if ($this->attemptUpdatePassword($request, $user)) {
            Session::flash('success','Password berhasil diperbarui');
        } else {
            Session::flash('failure','Password gagal diperbarui');
        }

        return view('admin.profile', compact('user'));
    }

    // ? SELF
    // VALIDATE ? User
    // function validasi update data admin kecuali password
    private function validateUpdateUser($request)
    {
        return self::ext_ValidateUpdateUser($request);
    }

    // ? SELF
    // VALIDATE ? User
    // function validasi update data admin hanya password
    private function validateUpdatePassword($request)
    {
        return self::ext_ValidateUpdatePassword($request);
    }

    // ? SELF
    // SAVE ? User
    // function update data admin kecuali password ke database
    private function attemptUpdateUser($request, $user)
    {
        return self::ext_AttemptUpdateUser($request, $user);
    }

    // ? SELF
    // SAVE ? User
    // function update data admin hanya password ke database
    private function attemptUpdatePassword($request, $user)
    {
        return self::ext_AttemptUpdatePassword($request, $user);
    }

    // *-----------------------------------------------------------------------
    // *     BROADCAST
    // *-----------------------------------------------------------------------

    // ? GET
    // VIEW :: admin.broadcast.index
    // halaman data siaran
    public function broadcast_index()
    {
        return view('admin.broadcast.index', ['broadcasts' => Broadcast::all()]);
    }

    // ? POST
    // ENDPOINT :: Broadcast store
    // api untuk menyimpan data siaran
    public function broadcast_store(Request $request)
    {
        $validator = $this->validateCreateBroadcast($request);
        if ($validator->fails()) return view('admin.broadcast.index')->withErrors($validator);

        if ($this->attemptCreateBroadcast($request)) {
            Session::flash('success', 'Data success');
        } else {
            Session::flash('failure', 'Data failure');
        }

        return view('admin.broadcast.index');
    }

    // ? DELETE
    // ENDPOINT :: Broadcast delete
    // api untuk menghapus siaran (hapus hanya untuk petani)
    public function broadcast_softDelete($id)
    {
        // $broadcast = Broadcast::find($id);
        // $broadcast->deleted = true;
        // $broadcast->save();

        return view('admin.broadcast.index');
    }

    // ? SELF
    // VALIDATE ? Broadcast
    // function validasi data siaran
    private function validateCreateBroadcast($request)
    {
        return self::ext_ValidateCreateBroadcast($request);
    }

    // ? SELF
    // SAVE ? Broadcast
    // function tambah data siaran ke database
    private function attemptCreateBroadcast($request)
    {
        return self::ext_AttemptCreateBroadcast($request);
    }

    // *-----------------------------------------------------------------------
    // *     FARMING
    // *-----------------------------------------------------------------------

    // ? GET
    // VIEW :: admin.farming.index
    // halaman data bertani
    public function farming_index()
    {
        // $farmings = Farming::all();
        return view('admin.farming.index');
    }

    // ? GET
    // VIEW :: admin.farming.create
    // halaman form tambah data bertani
    public function farming_create()
    {
        return view('admin.farming.create');
    }

    // ? POST
    // ENDPOINT :: Farming store
    // api untuk menyimpan data bertani
    public function farming_store(Request $request)
    {
        $validator = $this->validateCreateFarming($request);
        if ($validator->fails()) return view('admin.farming.index')->withErrors($validator);

        if ($this->attemptCreateFarming($request)) {
            Session::flash('success', 'Data success');
        } else {
            Session::flash('failure', 'Data failure');
        }

        return view('admin.farming.index');
    }

    // ? SELF
    // VALIDATE ? Farming
    // function validasi data bertani
    private function validateCreateFarming($request)
    {
        return self::ext_ValidateCreateFarming($request);
    }

    // ? SELF
    // SAVE ? Farming
    // function tambah data bertani ke database
    private function attemptCreateFarming($request)
    {
        return self::ext_AttemptCreateFarming($request);
    }

    // *-----------------------------------------------------------------------
    // *     PLANT
    // *-----------------------------------------------------------------------

    // ? GET
    // VIEW :: admin.plant.index
    // halaman data tanaman
    public function plant_index()
    {
        return view('admin.plant.index', ['plants' => Plant::all()]);
    }

    // ? GET
    // VIEW :: admin.plant.create
    // halaman form tambah data tanaman
    public function plant_create()
    {
        return view('admin.plant.create');
    }

    // ? POST
    // ENDPOINT :: Plant store
    // api untuk menyimpan data tanaman
    public function plant_store(Request $request)
    {
        $validator = $this->validateCreatePlant($request);
        if ($validator->fails()) return view('admin.plant.index')->withErrors($validator);

        if ($this->attemptCreatePlant($request)) {
            Session::flash('success', 'Data success');
        } else {
            Session::flash('failure', 'Data failure');
        }

        return view('admin.plant.index');
    }

    // ? SELF
    // VALIDATE ? Plant
    // function validasi data tanaman
    private function validateCreatePlant($request)
    {
        return self::ext_ValidateCreatePlant($request);
    }

    // ? SELF
    // SAVE ? Plant
    // function tambah data tanaman ke database
    private function attemptCreatePlant($request)
    {
        return self::ext_AttemptCreatePlant($request);
    }

    // *-----------------------------------------------------------------------
    // *     FARMER
    // *-----------------------------------------------------------------------

    // ? GET
    // VIEW :: admin.farmer.index
    // halaman data petani
    public function farmer_index()
    {
        return view('admin.farmer.index', ['farmers' => User::farmer(10)]);
    }

    // ? GET
    // VIEW :: admin.farmer.create
    // halaman form tambah data petani
    public function farmer_create()
    {
        return view('admin.farmer.create');
    }

    // ? POST
    // ENDPOINT :: User store
    // api untuk menyimpan data petani
    public function farmer_store(Request $request)
    {
        $validator = $this->validateCreateFarmer($request);
        if ($validator->fails()) return redirect()->route('admin.farmer.create')->withErrors($validator)->withInput($request->except('password_confirmation'));

        if ($this->attemptCreateFarmer($request)) {
            Session::flash('success', 'Data petani berhasil dibuat');
        } else {
            Session::flash('failure', 'Data failure');
        }

        return redirect()->route('admin.farmer');
    }

    // ? GET
    // VIEW :: admin.farmer.show
    // halaman detail petani
    public function farmer_show($id)
    {
        $farmer = User::find($id);
        if ($farmer->role != 'farmer') return redirect()->route('admin.farmer');
        return view('admin.farmer.show', compact('farmer'));
    }

    // ? GET
    // VIEW :: admin.farmer.edit
    // halaman form ubah data petani
    public function farmer_edit($id)
    {
        $farmer = User::find($id);
        if ($farmer->role != 'farmer') return redirect()->route('admin.farmer');
        return view('admin.farmer.edit', compact('farmer'));
    }

    // ? PUT
    // ENDPOINT :: User update
    // api untuk update data petani
    public function farmer_update(Request $request, $id)
    {
        $user = User::find($id);
        if ($user->role != 'farmer') return redirect()->route('admin.farmer');

        $validator = $this->validateUpdateUser($request);
        if ($validator->fails()) return redirect()->route('admin.farmer.edit')->withErrors($validator)->withInput($request->all());

        if ($this->attemptUpdateUser($request, $user)) {
            Session::flash('success','Data berhasil diperbarui');
        } else {
            Session::flash('failure','Data gagal diperbarui');
        }

        return redirect()->route('admin.farmer.show', ['id' => $farmer->id]);
    }

    // ? SELF
    // VALIDATE ? User
    // function validasi data petani
    private function validateCreateFarmer($request)
    {
        return self::ext_ValidateCreateFarmer($request);
    }

    // ? SELF
    // SAVE ? User
    // function tambah data petani ke database
    private function attemptCreateFarmer($request)
    {
        return self::ext_AttemptCreateFarmer($request);
    }

    // *-----------------------------------------------------------------------
    // *     SOIL MOISTURE
    // *-----------------------------------------------------------------------

    // ? GET
    // VIEW :: admin.soilmoisture.index
    // halaman data kelembaban tanah
    public function soilmoisture_index()
    {
        return view('admin.soilmoisture.index', ['soilmoistures' => SoilMoisture::paginate(20)]);
    }

    // ? GET
    // VIEW :: admin.soilmoisture.show
    // halaman data kelembaban tanah berdasarkan id mesin
    public function soilmoisture_show($machine_id)
    {
        return view('admin.soilmoisture.show', ['soilmoistures' => SoilMoisture::where('machine_id', $machine_id)->paginate(20)]);
    }

    // *-----------------------------------------------------------------------
    // *     WEATHER
    // *-----------------------------------------------------------------------

    // ? GET
    // VIEW :: admin.weather.index
    // halaman data cuaca (hari ini)
    public function weather_index()
    {
        $magetanId = '501289';
        $weather = Weather::area($magetanId);

        if (is_null($weather)) return redirect()->route('admin.weather');

        $attributes = Weather::getAttributesFrom($weather);
        $humidity = Weather::getHumidityFrom($weather);
        $minHumidity = Weather::getMinHumidityFrom($weather);
        $maxHumidity = Weather::getMaxHumidityFrom($weather);
        $temperature = Weather::getTemperatureFrom($weather);
        $minTemperature = Weather::getMinTemperatureFrom($weather);
        $maxTemperature = Weather::getMaxTemperatureFrom($weather);

        return view('admin.weather.index', compact(['attributes','humidity','minHumidity','maxHumidity','temperature','minTemperature','maxTemperature']));
    }
}
