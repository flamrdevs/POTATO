<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Hash;
use Session;

class AdminController extends Controller
{
    // middleware
    public function __construct()
    {
        $this->middleware(['auth','role:admin']);
    }

    public function index()
    {
        return view('admin.index');
    }

    public function profile()
    {
        return view('admin.profile');
    }

    // farmer management
    public function farmer_index()
    {
        $farmers = User::where('role','farmer')->get();
        return view('admin.farmer.index', compact('farmers'));
    }

    public function farmer_create()
    {
        return view('admin.farmer.create');
    }

    public function farmer_store(Request $request)
    {
        if ($this->validateCreateFarmer($request)) {
            return redirect()->route('admin.farmer.create')->withErrors($validator)->withInput($request->except('password_confirmation'));
        }

        if ($this->attemptCreateFarmer($request)) {
            Session::flash('success', 'Data petani berhasil dibuat');
            return redirect()->route('admin.farmer.index');
        } else {
            return redirect()->route('admin.farmer.create');
        }
    }

    public function farmer_show($id)
    {
        $farmer = User::where('id', $id)->get();
        return view('admin.farmer.show', compact('farmer'));
    }

    private function validateCreateFarmer($request)
    {
        $validator = Validator::make($request->all(), [
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

        return $validate->fails();
    }

    private function attemptCreateFarmer($request)
    {
        $user = new User;
        $user->name = ucwords(strtolower($request->name));
        $user->email = strtolower($request->email);
        $user->password = Hash::make($request->password);
        $user->role = 'farmer';

        return $user->save();
    }
}
