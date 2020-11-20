<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\SoilMoisture;
use Illuminate\Support\Facades\Auth;
use Validator;
use Hash;
use Session;

class AdminController extends Controller
{
    // Construct
    public function __construct()
    {
        $this->middleware(['auth','role:admin']);
    }

    // 
    // HOME
    // 

    // view admin home
    public function index()
    {
        return view('admin.index');
    }

    // view admin profile
    public function profile()
    {
        $user = User::find(Auth::user()->id);
        return view('admin.profile', compact('user'));
    }

    // view edit data admin
    public function edit()
    {
        $user = User::find(Auth::user()->id);
        return view('admin.edit', compact('user'));
    }

    // view ubah password
    public function password(Request $request)
    {
        return view('admin.password');
    }

    // api admin update
    public function update(Request $request)
    {
        $user = User::find(Auth::user()->id);
        
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

    // api admin update password
    public function updatePassword(Request $request)
    {
        $user = User::find(Auth::user()->id);

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
    // BROADCAST
    //

    // view pesan semua siaran
    public function broadcast_index()
    {
        return response()->json(['broadcast' => 'index'], 200);
    }

    // view buat data siaran
    public function broadcast_create()
    {
        return response()->json(['broadcast' => 'create'], 200);
    }

    // api siaran save
    public function broadcast_store(Request $request)
    {
        return response()->json(['broadcast' => 'store'], 200);
    }

    // 
    // FARMING
    //

    // view table semua bertani
    public function farming_index()
    {
        return response()->json(['farming' => 'index'], 200);
    }

    // view buat data bertani
    public function farming_create()
    {
        return response()->json(['farming' => 'create'], 200);
    }

    // api bertani save
    public function farming_store(Request $request)
    {
        return response()->json(['farming' => 'store'], 200);
    }

    // 
    // PLANT
    //

    // view table semua tanaman
    public function plant_index()
    {
        return response()->json(['plant' => 'index'], 200);
    }

    // view buat data tanaman
    public function plant_create()
    {
        return response()->json(['plant' => 'create'], 200);
    }

    // api tanaman save
    public function plant_store(Request $request)
    {
        return response()->json(['plant' => 'store'], 200);
    }

    // 
    // FARMER
    // 

    // view table semua petani
    public function farmer_index()
    {
        $farmers = User::where('role','farmer')->paginate(10);
        return view('admin.farmer.index', compact('farmers'));
    }

    // view buat akun petani
    public function farmer_create()
    {
        return view('admin.farmer.create');
    }

    // api petani save
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

    // view satu akun petani
    public function farmer_show($id)
    {
        $farmer = User::find($id);
        if ($farmer->role != 'farmer') {
            return redirect()->route('admin.farmer');
        }
        return view('admin.farmer.show', compact('farmer'));
    }

    // view edit akun petani
    public function farmer_edit($id)
    {
        $farmer = User::find($id);
        if ($farmer->role != 'farmer') {
            return redirect()->route('admin.farmer');
        }
        return view('admin.farmer.edit', compact('farmer'));
    }

    // api petani update
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

    // validasi buat akun petani
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

    // simpan akun petani
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

    // 
    // SOIL MOISTURE
    // 

    public function soilmoisture_index()
    {
        $soilmoistures = SoilMoisture::paginate(20);
        return view('admin.soilmoisture.index', compact('soilmoistures'));
    }

    public function soilmoisture_show($machine_id)
    {
        $soilmoistures = SoilMoisture::where('machine_id', $machine_id)->paginate(20);
        return view('admin.soilmoisture.show', compact('soilmoistures'));
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
            return redirect()->route('admin.weather');
        }

        return view('admin.weather.index', compact('weather'));
    }
}
