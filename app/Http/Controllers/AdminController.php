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

class AdminController extends Controller
{
    // ? CONSTRUCT
    public function __construct()
    {
        // Middleware
        // 1. Apakah sudah terautentikasi
        // 2. Apakah role user adalah admin
        $this->middleware(['auth','role:admin']);
    }

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
        $user = User::auth();
        return view('admin.profile', compact('user'));
    }

    // ? GET
    // VIEW :: admin.edit
    // halaman form ubah data admin
    public function edit()
    {
        $user = User::auth();
        return view('admin.edit', compact('user'));
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

        if ($validator->fails()) {
            return redirect()->route('admin.edit')->withErrors($validator)->withInput($request->all());
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

        return view('admin.profile', compact('user'));
    }

    // ? PUT
    // ENDPOINT :: User update
    // api untuk update data admin hanya password
    public function updatePassword(Request $request)
    {
        $user = User::auth();

        $validator = $this->validateUpdatePassword($request);

        if ($validator->fails()) {
            return redirect()->route('admin.password')->withErrors($validator)->withInput($request->all());
        }

        if (Hash::check($request->currentPassword, $user->password)) {
            $user->password = Hash::make($request->password);
        } else {
            Session::flash('password','Password saat ini salah');
            return redirect()->route('admin.password')->withErrors($validator)->withInput($request->all());
        }
        
        if ($user->save()) {
            Session::flash('success','Password berhasil diperbarui');
        } else {
            Session::flash('error','Password gagal diperbarui');
        }

        return view('admin.profile', compact('user'));
    }

    // ? SELF
    // VALIDATE ? User
    // function validasi update data admin kecuali password
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
    // function validasi update data admin hanya password
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

    // /___ A ++++

    // *-----------------------------------------------------------------------
    // *     BROADCAST
    // *-----------------------------------------------------------------------

    // ? GET
    // VIEW :: admin.broadcast.index
    // halaman data siaran
    public function broadcast_index()
    {
        $broadcasts = Broadcast::all();

        return view('admin.broadcast.index', compact('broadcasts'));
    }

    // ? POST
    // ENDPOINT :: Broadcast store
    // api untuk menyimpan data siaran
    public function broadcast_store(Request $request)
    {
        // $validator = $this->validateCreateBroadcast($request);
        // if ($validator->fails()) {
        //     return view('admin.broadcast.index')->withErrors($validator);
        // }

        // if ($this->attemptCreateBroadcast($request)) {
        //     Session::flash('success', 'Data success');
        // } else {
        //     Session::flash('failure', 'Data failure');
        // }

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
        return Validator::make($request->all(), [
            'message' => 'required',
        ], [
            'message.required' => 'Pesan harus di isi',
        ]);
    }

    // ? SELF
    // SAVE ? Broadcast
    // function tambah data siaran ke database
    private function attemptCreateBroadcast($request)
    {
        return Broadcast::create([
            'message' => $request->message
        ])->save();
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
        if ($validator->fails()) {
            return view('admin.farming.index')->withErrors($validator);
        }

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
        return Validator::make($request->all(), [
            'name' => 'required',
            'minHumidity' => 'required'
        ], [
            'name.required' => 'Pesan harus di isi',
            'minHumidity.required' => 'Data kelembaban minimal harus diisi'
        ]);
    }

    // ? SELF
    // SAVE ? Farming
    // function tambah data bertani ke database
    private function attemptCreateFarming($request)
    {
        return Farming::create([

        ])->save();
    }

    // *-----------------------------------------------------------------------
    // *     PLANT
    // *-----------------------------------------------------------------------

    // ? GET
    // VIEW :: admin.plant.index
    // halaman data tanaman
    public function plant_index()
    {
        $plants = Plant::all();

        return view('admin.plant.index', compact('plants'));
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
        if ($validator->fails()) {
            return view('admin.plant.index')->withErrors($validator);
        }

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
        return Validator::make($request->all(), [
            'name' => 'required',
            'minHumidity' => 'required'
        ], [
            'name.required' => 'Pesan harus di isi',
            'minHumidity.required' => 'Data kelembaban minimal harus diisi'
        ]);
    }

    // ? SELF
    // SAVE ? Plant
    // function tambah data tanaman ke database
    private function attemptCreatePlant($request)
    {
        return Plant::create([
            'name' => $request->name,
            'minHumidity' => $request->minHumidity
        ])->save();
    }

    // /___ A ----

    // *-----------------------------------------------------------------------
    // *     FARMER
    // *-----------------------------------------------------------------------

    // ? GET
    // VIEW :: admin.farmer.index
    // halaman data petani
    public function farmer_index()
    {
        $farmers = User::farmer(10);
        return view('admin.farmer.index', compact('farmers'));
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
        if ($validator->fails()) {
            return redirect()->route('admin.farmer.create')->withErrors($validator)->withInput($request->except('password_confirmation'));
        }

        if ($this->attemptCreateFarmer($request)) {
            Session::flash('success', 'Data petani berhasil dibuat');
            return redirect()->route('admin.farmer');
        } else {
            return redirect()->route('admin.farmer.create');
        }
    }

    // ? GET
    // VIEW :: admin.farmer.show
    // halaman detail petani
    public function farmer_show($id)
    {
        $farmer = User::find($id);
        if ($farmer->role != 'farmer') {
            return redirect()->route('admin.farmer');
        }
        return view('admin.farmer.show', compact('farmer'));
    }

    // ? GET
    // VIEW :: admin.farmer.edit
    // halaman form ubah data petani
    public function farmer_edit($id)
    {
        $farmer = User::find($id);
        if ($farmer->role != 'farmer') {
            return redirect()->route('admin.farmer');
        }
        return view('admin.farmer.edit', compact('farmer'));
    }

    // ? PUT
    // ENDPOINT :: User update
    // api untuk update data petani
    public function farmer_update(Request $request, $id)
    {
        $user = User::find($id);
        if ($user->role != 'farmer') {
            return redirect()->route('admin.farmer');
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

        return redirect()->route('admin.farmer.show',['id' => $farmer->id]);
    }

    // ? SELF
    // VALIDATE ? User
    // function validasi data petani
    private function validateCreateFarmer($request)
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

    // ? SELF
    // SAVE ? User
    // function tambah data petani ke database
    private function attemptCreateFarmer($request)
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

    // *-----------------------------------------------------------------------
    // *     SOIL MOISTURE
    // *-----------------------------------------------------------------------

    // ? GET
    // VIEW :: admin.soilmoisture.index
    // halaman data kelembaban tanah
    public function soilmoisture_index()
    {
        $soilmoistures = SoilMoisture::paginate(20);
        return view('admin.soilmoisture.index', compact('soilmoistures'));
    }

    // ? GET
    // VIEW :: admin.soilmoisture.show
    // halaman data kelembaban tanah berdasarkan id mesin
    public function soilmoisture_show($machine_id)
    {
        $soilmoistures = SoilMoisture::where('machine_id', $machine_id)->paginate(20);
        return view('admin.soilmoisture.show', compact('soilmoistures'));
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

        if ($weather == null) {
            return redirect()->route('admin.weather');
        }

        $attributes = $weather['attributes'];
        $humidity = $weather['humidity'];
        $minHumidity = $weather['minHumidity']['timerange'][0]['value'];
        $maxHumidity = $weather['maxHumidity']['timerange'][0]['value'];
        $temperature = $weather['temperature'];
        $minTemperature = $weather['minTemperature']['timerange'][0]['value'][0];
        $maxTemperature = $weather['maxTemperature']['timerange'][0]['value'][0];

        return view('admin.weather.index', compact(['attributes','humidity','minHumidity','maxHumidity','temperature','minTemperature','maxTemperature']));
    }
}
