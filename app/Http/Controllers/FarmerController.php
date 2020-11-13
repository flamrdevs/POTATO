<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FarmerController extends Controller
{
    // middleware
    public function __construct()
    {
        $this->middleware(['auth','role:farmer']);
    }

    public function index()
    {
        return view('farmer.index');
    }

    public function profile()
    {
        return view('farmer.profile');
    }
}
