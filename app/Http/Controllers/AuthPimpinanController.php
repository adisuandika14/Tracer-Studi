<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\admins;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthPimpinanController extends Controller
{
     // Access only on API
     public function register(Request $request)
     {
         $user = new admins();
         $user->nama ->request->nama;
         $user->username = $request->username;
         $user->password = bcrypt($request->password);
         $user->role = $request->role;
         $user->save();
 
         return 'sukses';
     }
 
     public function loginForm()
     {
         return view('adminpages.auth.login');
     }
 
     public function login(Request $request)
     {
         if(Auth::guard()->attempt(['username' => $request->username, 'password' => $request->password])){
             return redirect()->route('/pimpinan/dashboard');
         } else {
             return redirect()->back()->with('error', 'Username atau Password Anda Salah');
         }
     }
 
     public function logout()
     {
         Auth::guard()->logout();
 
         return redirect()->route('Index', 'id');
     }
 
     public function profile()
     {
         return view('/auth/pimpinan/profile');
     }
 
     public function updateProfile(Request $request){
         $validator = Validator::make($request->all(), [
             'nama' => 'required',
             'username' => 'required:unique:admins'
         ],[
             'nama.required' => "Nama wajib diisi",
             'username.required' => "Username wajib diisi",
             'username.unique' => "Username telah terdaftar",
         ]);
 
         if($validator->fails()){
             return back()->withErrors($validator);
         }
 
         $admin = admins::find(Auth::user()->id);
         $admin->nama = $request->nama;
         $admin->username=$request->username;
         $admin->email=$request->email;
         $admin->no_tlp=$request->no_tlp;
 
         if($request->foto!=''){
             $image_parts = explode(';base64', $request->foto);
             $image_type_aux = explode('image/', $image_parts[0]);
             $image_type = $image_type_aux[1];
             $image_base64 = base64_decode($image_parts[1]);
             $filename = uniqid().'.png';
             $fileLocation = '/image/admin/profile';
             $path = $fileLocation."/".$filename;
             $admin->foto = '/storage'.$path;
             Storage::disk('public')->put($path, $image_base64);
         }
 
         $admin->update();
 
         return redirect('pimpinan/profile')->with('statusInput', 'Data profile berhasil disimpan');
     }
 
     public function password(){
         return view('adminpages.auth.password');
     }
 
     public function editpassword(Request $request){
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
 
         $admin = admins::find(Auth::user()->id);
         if (Hash::check($request->password_lama, $admin->password)) {
             admins::where('id', $admin->id)->update([
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
