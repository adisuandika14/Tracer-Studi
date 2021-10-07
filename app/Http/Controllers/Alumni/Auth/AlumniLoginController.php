<?php

namespace App\Http\Controllers\Alumni\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Alumni;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AlumniLoginController extends Controller
{
    // public function __construct()
    // {
    //     // check if session expired for ajax request
    //     $this->middleware('ajax-session-expired');

    //     // check if user is autenticated for non-ajax request
    //     $this->middleware('auth');
    // }

    public function index(Request $request){
        if(session('admin')){
            return redirect('/admin/dashboard');
        } elseif (session('pimpinan')){
            return redirect('/pimpinan/dashboard');
        } elseif (session('alumni')){
            return redirect('/alumni/dashboard');
        } else {
            return view('auth/alumniLogin');
        }
    }


    public function login(Request $request){
        $user = Alumni::where('nim_alumni',$request->nim_alumni)->first();
        //validasi data di form
        $this->validate($request,[
            'nim_alumni'=>'required|string|min:10',
            'password'=>'required|min:5|max:20'
        ]);
        //percobaan login
        if($user){
            if(Auth::guard('alumni')->attempt([
                'nim_alumni'=> $request->nim_alumni,
                'password'=> $request->password])){
                //redirect jika sukses login
                Auth::login($user);
                session(['alumni'=>true]);
                return redirect ('/alumni/dashboard');
            }else {
                //redirect jika gagal login
                return redirect()->back()->with('error','Password Tidak Sesuai!');
            }
        }elseif($request->nim_alumni){
            return redirect()->back()->with('error','NIM Tidak Terdaftar!');
        }else {
             return redirect('/alumni/login');
        }
    }

    public function logout(Request $request){
        $request->session()->flush();
        return redirect('/alumni/login');
    }
}
