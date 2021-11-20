<?php

namespace App\Http\Controllers\Alumni\Auth;

use App\tb_angkatan;
use App\tb_periode_kuesioner;
use App\tb_prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Alumni;
use Illuminate\Support\Facades\Auth;

class AlumniRegisterController extends Controller
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function index()
    {
        $prodi = tb_prodi::get();
        $angkatan = tb_angkatan::get();
        return view('/auth/alumniRegister', compact( 'prodi', 'angkatan'));
    }

    public function regisAlumni(Request $request){
        $validator = Validator::make($request->all(), [
            'nama_alumni' => 'required',
            'nim_alumni' => 'required|unique:tb_alumni|max:10',
            'prodi' => 'required',
            'gender' => 'required',
            'angkatan' => 'required',
            'tahun_lulus' => 'required',
            'tahun_wisuda' => 'required',
            'alamat_alumni' => 'required',
            'email' => 'required|unique:tb_alumni',
            'password' => 'required|min:8',
            'repeat_password' => 'required|same:password',
            'nik' => 'required|min:16|max:16|unique:tb_alumni',
            'id_telegram' => 'required|unique:tb_alumni',
            'id_line' => 'required|unique:tb_alumni',
            'no_hp' => 'required',
            'transkrip' => 'required|mimes:pdf|max:512',
        ],[
            'nama.required' => "Nama wajib diisi",
            'email.required' => "Email wajib diisi",
            'prodi.required' => "Program studi wajib dipilih",
            'gender.required' => "Jenis kelamin wajib dipilih",
            'angkatan.required' => "Angkatan wajib dipilih",
            'password.required' => "Password wajib diisi",
            'repeat_password.required' => "Ulangi password wajib diisi",
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
            'password.min' => "Password minimal 8 karakter",
            'repeat_password.same' => "Password tidak sama",
        ]);

        if($validator->fails()){
            return back()->withErrors($validator);
        }

        else{
            $periode = tb_periode_kuesioner::orderBy('id_periode_kuesioner', 'DESC')
                ->where('status', 'Aktif')->first();
            $user = new Alumni();
            $user->nama_alumni = $request->nama_alumni;
            $user->nim_alumni = $request->nim_alumni;
            $user->id_prodi = $request->prodi;
            $user->jenis_kelamin = $request->gender;
            $user->id_angkatan = $request->angkatan;
            $user->tahun_lulus = $request->tahun_lulus;
            $user->tahun_wisuda = $request->tahun_wisuda;
            $user->alamat_alumni=$request->alamat_alumni;
            $user->email=$request->email;
            $user->password=Hash::make($request->password);
            $user->nik=$request->nik;
            $user->id_telegram=$request->id_telegram;
            $user->id_line=$request->id_line;
            $user->no_hp=$request->no_hp;
            $user->id_periode = $periode->id_periode;
            $user->status="Menunggu Konfirmasi";

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

            $user->save();

        }


        return redirect('/alumni/login')->with('success', 'Berhasil registrasi, silakan login');
    }
}
