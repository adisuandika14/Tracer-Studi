<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class loginController extends Controller
{

    public function index(Request $request){
        if(session('admin')){
            return redirect('/admin/dashboard');
        } elseif (session('pimpinan')){
            return redirect('/pimpinan/dashboard');
        } elseif (session('alumni')) {
            return redirect('/alumni/dashboard');
        }else {
            return view('auth/login');
        }
    }


    public function login(Request $request){
        $user = User::where('nip',$request->nip)->first();
        if($user){
            if(Hash::check($request->password, $user->password)){
                if (Auth::attempt(['nip' => $request->nip, 'password' => $request->password])){
                    if($user->role == 1){
                        session(['admin'=>true]);
                        return redirect('/admin/dashboard');
                    } elseif ($user->role == 2){
                        session(['pimpinan'=>true]);
                        return redirect('/pimpinan/dashboard');
                    }
                }
            } else {
                return redirect('/');
            }
        } else {
            return redirect('/');
        }
    }

    public function logout(Request $request){
        $request->session()->flush();
        return redirect('/');
    }
}
