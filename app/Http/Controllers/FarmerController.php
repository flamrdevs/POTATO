<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Framework
use Illuminate\Support\Carbon;
use Validator;
use Hash;
use Session;

// Model
use App\User;
use App\Plant;
use App\Machine;
use App\Farming;
use App\SoilMoisture;
use App\Watering;
use App\Broadcast;
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
        $farmings = Farming::activeWithUserPlantMachineFindByUserId(User::auth()->id);
        $farmingsId = $farmings->map(function($val) {
            return $val->id;
        });
        $count = [
            'farming' => [
                'berlangsung' => Farming::statusTrueFindByUserId(User::auth()->id)->count(),
                'selesai' => Farming::statusFalseFindByUserId(User::auth()->id)->count()
            ]
        ];

        $weather = Weather::area('501289');
        if (is_null($weather)) return redirect()->route('admin');

        $average = [
            'today' => [
                'soilMoisture' => SoilMoisture::whereDate('timestamp', Carbon::today())->whereIn('farming_id', $farmingsId)->avg('value'),
                'whumidity' => collect(Weather::getHumidityFrom($weather)['timerange'])->whereIn('@attributes.h', ['0','6','12','18'])->map(function($val) { return (float)$val['value']; })->avg(),
                'wtemperature' => collect(Weather::getTemperatureFrom($weather)['timerange'])->whereIn('@attributes.h', ['0','6','12','18'])->map(function($val) { return (float)$val['value'][0]; })->avg()
            ]
        ];
        return view('farmer.index', compact('count', 'farmings', 'average'));
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
    // *     BROADCAST
    // *-----------------------------------------------------------------------

    // ? GET
    // VIEW :: farmer.broadcast.index
    // halaman data siaran
    public function broadcast_index()
    {
        return view('farmer.broadcast.index', ['broadcasts' => Broadcast::latest()->paginate(10)]);
    }

    // ? GET
    // VIEW :: farmer.broadcast.show
    // halaman detail siaran
    public function broadcast_show($id)
    {
        return view('farmer.broadcast.show', ['broadcast' => Broadcast::findOrFail($id)]);
    }

    // *-----------------------------------------------------------------------
    // *     FARMING
    // *-----------------------------------------------------------------------

    // ? GET
    // VIEW :: farmer.farming.index
    // halaman data bertani
    public function farming_index()
    {
        $farmings = Farming::withUserPlantMachineFindByUserId(User::auth()->id);
        return view('farmer.farming.index', compact('farmings'));
    }

    // ? GET
    // VIEW :: farmer.farming.soilmoistures
    // halaman detail bertani bagian kelembaban tanah
    public function farming_soilmoistures($id)
    {
        $farming = Farming::withUserPlantMachineFind($id);
        if ($farming->user['id'] != User::auth()->id) return redirect()->route('farmer.farming');
        $soilmoistures = SoilMoisture::findByFarmingIdPaginate($id);
        return view('farmer.farming.soilmoistures', compact('soilmoistures', 'farming'));
    }

    // ? GET
    // VIEW :: farmer.farming.waterings
    // halaman detail bertani bagian penyiraman
    public function farming_waterings($id)
    {
        $farming = Farming::withUserPlantMachineFind($id);
        if ($farming->user['id'] != User::auth()->id) return redirect()->route('farmer.farming');
        $waterings = Watering::findByFarmingIdPaginate($id);
        return view('farmer.farming.waterings', compact('waterings', 'farming'));
    }

    // ? GET
    // VIEW :: farmer.farming.create
    // halaman form tambah data bertani
    public function farming_create()
    {
        $farmers = User::farmer();
        $plants = Plant::all();
        $machines = Machine::ready();
        return view('farmer.farming.create', compact('farmers', 'plants', 'machines'));
    }

    // ? POST
    // ENDPOINT :: Farming store
    // api untuk menyimpan data bertani
    public function farming_store(Request $request)
    {
        $validator = $this->validateCreateUpdateFarming($request);
        if ($validator->fails()) return redirect()->route('farmer.farming.create')->withErrors($validator)->withInput($request->all());

        if ($this->attemptCreateFarming($request)) {
            Session::flash('success', 'Data success');
            // success callback - update machine status
            if (!is_null($request->machine)) {
                Machine::statusToUsed($request->machine);
            }
        } else {
            Session::flash('failure', 'Data failure');
        }

        return redirect()->route('farmer.farming');
    }

    // ? GET
    // VIEW :: farmer.farming.show
    // halaman detail bertani
    public function farming_show($id)
    {
        $farming = Farming::withUserPlantMachineFind($id);
        if ($farming->user['id'] != User::auth()->id) return redirect()->route('farmer.farming');
        $today = [
            'soilmoisture' => SoilMoisture::whereDate('timestamp', Carbon::today())->where('farming_id', $farming->id)->get(),
            'watering' => Watering::whereDate('start', Carbon::today())->where('farming_id', $farming->id)->get()
        ];
        return view('farmer.farming.show', compact('farming', 'today'));
    }

    // ? GET
    // VIEW :: farmer.farming.edit
    // halaman form ubah data masa bertani
    public function farming_edit($id)
    {
        $farming = Farming::withUserPlantMachineFind($id);
        if ($farming->user['id'] != User::auth()->id) return redirect()->route('farmer.farming');
        if (!$farming->status) return redirect()->route('farmer.farming.show', ['id' => $farming->id]);
        $farmers = User::farmer();
        $plants = Plant::all();
        $machines = Machine::ready();
        return view('farmer.farming.edit', compact('farming', 'farmers', 'plants', 'machines'));
    }

    // ? PUT
    // ENDPOINT :: Farming update
    // api untuk update data petani
    public function farming_update(Request $request, $id)
    {
        $farming = Farming::withUserPlantMachineFind($id);
        if ($farming->user['id'] != User::auth()->id) return redirect()->route('farmer.farming');

        if ($request->status) {
            if ($this->attemptUpdateFarming($request, $farming)) {
                Session::flash('success','Data berhasil diperbarui');
                // success callback - update machine status
                if (!is_null($farming->machine_code)) {
                    Machine::statusToReady($farming->machine_code);
                }
            } else {
                Session::flash('failure','Data gagal diperbarui');
            }

            return redirect()->route('farmer.farming');
        }

        $validator = $this->validateCreateUpdateFarming($request);
        if ($validator->fails()) return redirect()->route('farmer.farming.edit', ['id' => $farming->id])->withErrors($validator)->withInput($request->all());

        $currentMachineCode = $farming->machine_code;

        if ($this->attemptUpdateFarming($request, $farming)) {
            Session::flash('success','Data berhasil diperbarui');
            // success callback - update machine status
            if (!is_null($request->machine)) {
                Machine::statusToUsed($request->machine);
            }
            if (!is_null($currentMachineCode)) {
                Machine::statusToReady($currentMachineCode);
            }
        } else {
            Session::flash('failure','Data gagal diperbarui');
        }

        return redirect()->route('farmer.farming.show', ['id' => $farming->id]);
    }

    // ? SELF
    // VALIDATE ? Farming
    // function validasi data bertani
    private function validateCreateUpdateFarming($request)
    {
        return self::ext_ValidateCreateUpdateFarming($request);
    }

    // ? SELF
    // SAVE ? Farming
    // function tambah data bertani ke database
    private function attemptCreateFarming($request)
    {
        return self::ext_AttemptCreateFarming($request);
    }

    // ? SELF
    // SAVE ? Farming
    // function update data masa bertani ke database
    private function attemptUpdateFarming($request, $farming)
    {
        return self::ext_AttemptUpdateFarming($request, $farming);
    }

    // *-----------------------------------------------------------------------
    // *     PLANT
    // *-----------------------------------------------------------------------

    // ? GET
    // VIEW :: farmer.plant.index
    // halaman data tanaman
    public function plant_index()
    {
        return view('farmer.plant.index', ['plants' => Plant::paginate(10)]);
    }

    // ? GET
    // VIEW :: farmer.plant.show
    // halaman detail tanaman
    public function plant_show($id)
    {
        return view('farmer.plant.show', ['plant' => Plant::findOrFail($id)]);
    }

    // *-----------------------------------------------------------------------
    // *     FARMER
    // *-----------------------------------------------------------------------

    // // ? GET
    // // VIEW :: farmer.farmer.index
    // // halaman data petani
    // public function farmer_index()
    // {
    //     return view('farmer.farmer.index', ['farmers' => User::farmer(10)]);
    // }

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
