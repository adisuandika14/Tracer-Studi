<?php

namespace App\Http\Controllers\Alumni;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;

class DashboardAlumniController extends Controller
{
    protected $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:alumni');
    }
    public function dashboard(){
        return view('/alumni/dashboard');
    }
}
