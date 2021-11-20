<?php

namespace App\Http\Controllers\Alumni;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Alumni;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PasswordController extends Controller
{
    // public function __construct()
    // {
    //     // check if session expired for ajax request
    //     $this->middleware('ajax-session-expired');

    //     // check if user is autenticated for non-ajax request
    //     $this->middleware('auth');
    // }

    public function __construct()
    {
        $this->middleware('auth:alumni');
    }

    public function password(){
        return view('alumni.resetPass');
    }

    public function updatepassword(Request $request){
//        dd(Auth::user());
        $validator = Validator::make($request->all(), [
            'password_lama' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required|same:password'
        ],[
            'password_confirmation.same' => "Konfirmasi password baru tidak sesuai",
        ]);

        if($validator->fails()){
            return back()->withErrors($validator);
        }


        if (Hash::check($request->password_lama, Auth::user()->password)) {
            Alumni::where('id_alumni', Auth::user()->id_alumni)->update([
                'password' => bcrypt($request->password)
            ]);
            //dd($admin->nama);
            return redirect()->back()->with('statusInput', 'Password berhasil diganti');
        } else{
            //dd($admin->nama);
            return redirect()->back()->with('error', 'Password lama salah');
        }
    }
}
