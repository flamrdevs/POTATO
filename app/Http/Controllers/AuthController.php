<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Hash;
use Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin');
        }
        return view('auth.login');
    }

    private function validateLogin($request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email harus di isi',
            'password.required' => 'Password harus di isi',
        ]);

        return $validate->fails();
    }

    private function attemptLogin($request)
    {
        Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        return Auth::check();
    }

    private function redirectUser()
    {
        if (Auth::user()->role == 'admin') {
            return redirect()->route('admin');
        } else {
            return redirect()->route('farmer');
        }
    }
    
    public function login(Request $request)
    {
        if ($this->validateLogin($request)) {
            return redirect()->route('login')->withErrors($validator)->withInput($request->except('password'));
        }

        if ($this->attemptLogin($request)) {
            return $this->redirectUser();
        } else {
            Session::flash('error', 'Maaf username dan password anda tidak sesuai. Harap periksa kembali');
            return redirect()->route('login')->withInput($request->except('password'));
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}