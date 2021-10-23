<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\tb_angkatan;
use App\tb_prodi;
use App\tb_notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Alumni;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;


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

         if($request->foto!=''){
             $image_parts = explode(';base64', $request->foto);
             $image_type_aux = explode('image/', $image_parts[0]);
             $image_type = $image_type_aux[1];
             $image_base64 = base64_decode($image_parts[1]);
             $filename = uniqid().'.png';
             $fileLocation = '/image/alumni/profile';
             $path = $fileLocation."/".$filename;
             $user->foto = '/storage'.$path;
             Storage::disk('public')->put($path, $image_base64);
         }

         $user->update();

         return redirect('/alumni/profile')->with('statusInput', 'Data profile berhasil disimpan');
     }

    public function perbaikan()
    {
        $prodi = tb_prodi::get();
        $angkatan = tb_angkatan::get();
        return view('/alumni/perbaikan', compact('prodi', 'angkatan'));
    }

     public function perbaikanAlumni(Request $request){
         $validator = Validator::make($request->all(), [
             'nama_alumni' => 'required',
             'nim_alumni' => 'required|max:10|unique:tb_alumni',
             'nim_alumni' => [Rule::unique('tb_alumni')->ignore(Auth::user()->id_alumni, 'id_alumni')],
             'prodi' => 'required',
             'gender' => 'required',
             'angkatan' => 'required',
             'tahun_lulus' => 'required',
             'tahun_wisuda' => 'required',
             'alamat_alumni' => 'required',
             'email' => 'required|unique:tb_alumni',
             'email' => [Rule::unique('tb_alumni')->ignore(Auth::user()->id_alumni, 'id_alumni')],
//             'password' => 'required|min:8',
//             'repeat_password' => 'required|same:password',
             'nik' => 'required|min:16|max:16|unique:tb_alumni',
             'nik' => [Rule::unique('tb_alumni')->ignore(Auth::user()->id_alumni, 'id_alumni')],
             'id_telegram' => 'required|unique:tb_alumni',
             'id_telegram' => [Rule::unique('tb_alumni')->ignore(Auth::user()->id_alumni, 'id_alumni')],
             'id_line' => 'required|unique:tb_alumni',
             'id_line' => [Rule::unique('tb_alumni')->ignore(Auth::user()->id_alumni, 'id_alumni')],
             'no_hp' => 'required',
             'transkrip' => 'mimes:pdf|max:512',
         ],[
             'nama.required' => "Nama wajib diisi",
             'email.required' => "Email wajib diisi",
             'prodi.required' => "Program studi wajib dipilih",
             'gender.required' => "Jenis kelamin wajib dipilih",
             'angkatan.required' => "Angkatan wajib dipilih",
//             'password.required' => "Password wajib diisi",
//             'repeat_password.required' => "Ulangi password wajib diisi",
             'nik.required' => "NIK wajib diisi",
             'id_telegram.required' => "ID Telegram wajib diisi",
             'id_line.required' => "ID Line wajib diisi",
             'tahun_lulus.required' => "Tahun lulus wajib dipilih",
             'tahun_wisuda.required' => "Tahun wisuda wajib dipilih",
             'alamat_alumni.required' => "Alamat wajib diisi",
             'nim_alumni.required' => "NIM wajib diisi",
             'transkrip.required' => "Transkrip wajib dilampirkan",
             'no_hp.required' => "Nomor handphone wajib diisi",

             'email.unique' => "Email telah terdaftar",
             'nim_alumni.unique' => "NIM telah digunakan",
             'nik.unique' => "NIK telah digunakan",
             'id_telegram.unique' => "ID Telegram telah digunakan",
             'id_line.unique' => "ID Line telah digunakan",

             'nim.max' => "NIM maksimal 10 karakter",
             'transkrip.max' => "Ukuran file lebih dari 500kb",
             'transkrip.mimes' => "Hanya menerima file berekstensi pdf",
             'nik.max' => "NIK terdiri dari 16 karakter",
             'nik.min' => "NIK terdiri dari 16 karakter",
//             'password.min' => "Password minimal 8 karakter",
//             'repeat_password.same' => "Password tidak sama",
         ]);

         if($validator->fails()){
             return back()->withErrors($validator);
         }

         else{
             $user = Alumni::find(Auth::user()->id_alumni);
             $user->nama_alumni = $request->nama_alumni;
             $user->nim_alumni = $request->nim_alumni;
             $user->id_prodi = $request->prodi;
             $user->jenis_kelamin = $request->gender;
             $user->id_angkatan = $request->angkatan;
             $user->tahun_lulus = $request->tahun_lulus;
             $user->tahun_wisuda = $request->tahun_wisuda;
             $user->alamat_alumni=$request->alamat_alumni;
             $user->email=$request->email;
//             $user->password=Hash::make($request->password);
             $user->nik=$request->nik;
             $user->id_telegram=$request->id_telegram;
             $user->id_line=$request->id_line;
             $user->no_hp=$request->no_hp;
             $user->status="Mengajukan Perbaikan";

             if($request->hasFile('transkrip')){
                 $nim = $request->nim_alumni;
                 $file = $request->file('transkrip');
                 $fileLocation = '/file/transkrip_alumni';
                 $filename = $nim."_transkripNilai".".".$file->getClientOriginalExtension();
                 $path = $fileLocation."/".$filename;
                 $user->transkrip = '/storage'.$path;
                 $user->transkrip_name = $filename;
                 Storage::disk('public')->put($path, file_get_contents($file));
             }

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



         }

         $status = new tb_notifikasi();
         $status->id_alumni = Auth::user()->id_alumni;
         $status->notifikasi = "Perbaikan data berhasil, silakan menunggu untuk dikonfirmasi";
         $status->notifikasi_unique = Str::random(32);
         $status->status = "Diterima";
         $status->flag = '0';
         $status->save();
         return redirect('/alumni/dashboard');
     }

//     public function password(){
//         return view('adminpages.auth.password');
//     }

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
