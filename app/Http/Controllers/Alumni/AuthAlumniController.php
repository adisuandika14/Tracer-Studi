<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Alumni;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthAlumniController extends Controller
{
     public function __construct()
     {
         $this->middleware('auth:alumni');
     }

     public function profile()
     {
         return view('/auth/alumni/profile');
     }

     public function updateProfile(Request $request){
         $validator = Validator::make($request->all(), [
             'nama_alumni' => 'required',
             'email' => 'required:unique:alumni'
         ],[
             'nama.required' => "Nama wajib diisi",
             'email.required' => "Username wajib diisi",
             'email.unique' => "Username telah terdaftar",
         ]);

         if($validator->fails()){
             return back()->withErrors($validator);
         }

         $user = Alumni::find(Auth::user()->id_alumni);
         $user->nama_alumni = $request->nama_alumni;
         $user->alamat_alumni=$request->alamat_alumni;
         $user->email=$request->email;
         $user->id_telegram=$request->id_telegram;
         $user->id_line=$request->id_line;
         $user->no_hp=$request->no_hp;

//         if($request->foto!=''){
//             $image_parts = explode(';base64', $request->foto);
//             $image_type_aux = explode('image/', $image_parts[0]);
//             $image_type = $image_type_aux[1];
//             $image_base64 = base64_decode($image_parts[1]);
//             $filename = uniqid().'.png';
//             $fileLocation = '/image/alumni/profile';
//             $path = $fileLocation."/".$filename;
//             $admin->foto = '/storage'.$path;
//             Storage::disk('public')->put($path, $image_base64);
//         }

         $user->update();

         return redirect('/alumni/profile')->with('statusInput', 'Data profile berhasil disimpan');
     }

     public function password(){
         return view('adminpages.auth.password');
     }

//     public function editpassword(Request $request){
//         $validator = Validator::make($request->all(), [
//             'password_lama' => 'required',
//             'password' => 'required',
//             'password_confirmation' => 'required|same:password'
//         ],[
//             'password_confirmation.same' => "Konfirmasi password baru tidak sesuai",
//         ]);
//
//         if($validator->fails()){
//             return back()->withErrors($validator);
//         }
//
//         $admin = admins::find(Auth::user()->id);
//         if (Hash::check($request->password_lama, $admin->password)) {
//             admins::where('id', $admin->id)->update([
//                 'password' => bcrypt($request->password)
//             ]);
//             //dd($admin->nama);
//             return redirect()->back()->with('statusInput', 'Password berhasil diganti');
//         } else{
//             //dd($admin->nama);
//             return redirect()->back()->with('error', 'Password lama salah');
//         }
//     }
}
