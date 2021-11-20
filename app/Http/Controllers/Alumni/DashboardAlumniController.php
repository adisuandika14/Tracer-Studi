<?php

namespace App\Http\Controllers\Alumni;
use App\Alumni;
use App\Http\Controllers\Alumni\Auth\AlumniRegisterController;
use App\tb_notifikasi;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DashboardAlumniController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:alumni');
        $this->middleware('reset_pass');
    }
    public function dashboard(){
        $notifs = tb_notifikasi::where('id_alumni',Auth::user()->id_alumni)->where('flag','0')->get();
//        dd($notifs);
        return view('/alumni/dashboard', compact ('notifs'));
    }

    public function bacaNotif($notifikasi_unique)
    {
        $id = tb_notifikasi::where('notifikasi_unique', $notifikasi_unique)->first();
        $notif = $id->id_notifikasi;
        $notif = tb_notifikasi::find($notif);
        $notif->flag = '1';
        $notif->save();

        return redirect()->back();
    }
}
