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
    // Construct
    public function __construct()
    {
        $this->middleware('guest', ['only' => ['showLoginForm']]);
    }

    // form
    public function showLoginForm()
    {   
        return view('auth.login');
    }

    // validate
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

    // attempt
    private function attemptLogin($request)
    {
        Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        return Auth::check();
    }

    // redirect
    private function redirectUser()
    {
        if (Auth::user()->role == 'admin') {
            return redirect()->route('admin');
        } else {
            return redirect()->route('farmer');
        }
    }
    
    // login
    public function login(Request $request)
    {   
        $validator = $this->validateLogin($request);
        if ($validator->fails()) {
            return redirect()->route('login')->withErrors($validator)->withInput($request->except('password'));
        }

        if ($this->attemptLogin($request)) {
            return $this->redirectUser();
        } else {
            Session::flash('error', 'Maaf username dan password anda tidak sesuai. Harap periksa kembali');
            return redirect()->route('login')->withInput($request->except('password'));
        }
    }

    // logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
