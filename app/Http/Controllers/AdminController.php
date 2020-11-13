<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

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

    public function farmer_show()
    {

    }

    public function farmer_create()
    {

    }

    public function farmer_edit()
    {

    }

    public function farmer_store()
    {

    }

    public function farmer_update()
    {

    }

    public function farmer_delete()
    {

    }
}
