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

    ///___----------------___///
    ///.__ AuthController __.///
    ///..__________________..///

    // *-----------------------------------------------------------------------
    // *     LOGIN
    // *-----------------------------------------------------------------------

    // ? GET
    // VIEW :: auth.login
    // halaman form masuk aplikasi
    public function showLoginForm()
    {
        return view('auth.login');
    }
    
    // ? POST
    // ENDPOINT :: User auth
    // api untuk masuk aplikasi
    public function login(Request $request)
    {
        $validator = $this->validateLogin($request);
        if ($validator->fails()) {
            return redirect()->route('login')->withErrors($validator)->withInput($request->except('password'));
        }

        if ($this->attemptLogin($request)) {
            return $this->redirectUser();
        } else {
            Session::flash('failure', 'Maaf username dan password anda tidak sesuai. Harap periksa kembali');
            return redirect()->route('login')->withInput($request->except('password'));
        }
    }

    // ? SELF
    // VALIDATE ? User
    // function validasi masuk aplikasi
    private function validateLogin($request)
    {
        return Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email harus di isi',
            'password.required' => 'Password harus di isi',
        ]);
    }

    // ? SELF
    // CHECK ? User auth
    // function autentikasi user untuk masuk aplikasi
    private function attemptLogin($request)
    {
        Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        return Auth::check();
    }

    // ? SELF
    // REDIRECT ? User role
    // function redirect user sesuai role
    private function redirectUser()
    {
        switch (Auth::user()->role) {
            case 'admin':
                return redirect()->route('admin');
            case 'farmer':
                return redirect()->route('farmer');
            default:
                Auth::logout();
                return redirect()->route('welcome');
        }
    }

    // *-----------------------------------------------------------------------
    // *     LOGOUT
    // *-----------------------------------------------------------------------

    // ? POST
    // ENDPOINT :: User auth
    // api untuk keluar aplikasi
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
