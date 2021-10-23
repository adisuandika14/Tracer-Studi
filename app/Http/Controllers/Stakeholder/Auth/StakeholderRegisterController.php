<?php

namespace App\Http\Controllers\Stakeholder\Auth;

use App\Stakeholder;
use App\tb_angkatan;
use App\tb_kuesioner_stakeholder;
use App\tb_opsi_stakeholder;
use App\tb_periode_kuesioner;
use App\tb_prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StakeholderRegisterController extends Controller
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
     * @param array $data
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
        return view('/auth/stakeholderRegister', compact('prodi'));
    }

    public function regisStakeholder(Request $request)
    {
        $periode = tb_periode_kuesioner::find(\DB::table('tb_periode_kuesioner')->max('id_periode_kuesioner'));
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'nama_instansi' => 'required',
            'jabatan' => 'required',
            'email' => 'required|unique:tb_stakeholder',
            'prodi' => 'required',
        ], [
            'nama.required' => "Nama wajib diisi",
            'nama_instansi.required' => "Nama Instansi wajib diisi",
            'jabatan.required' => "Jabatan wajib diisi",
            'email.required' => "Email wajib diisi",
            'prodi.required' => "Program studi wajib dipilih",

            'email.unique' => "Email sudah pernah digunakan",
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        } else {
            $stakeholder = new Stakeholder();
            $stakeholder->nama = $request->nama;
            $stakeholder->nama_instansi = $request->nama_instansi;
            $stakeholder->email = $request->email;
            $stakeholder->jabatan = $request->jabatan;
            $stakeholder->id_periode = $periode->id_periode_kuesioner;

//            if($request->hasFile('transkrip')){
//                $nim = $request->nim_alumni;
//                $file = $request->file('transkrip');
//                $fileLocation = '/file/transkrip_alumni';
//                $filename = $nim."_transkripNilai".".".$file->getClientOriginalExtension();
//                $path = $fileLocation."/".$filename;
//                $stakeholder->transkrip = '/storage'.$path;
//                $stakeholder->transkrip_name = $filename;
//                Storage::disk('public')->put($path, file_get_contents($file));
//            }

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

            $stakeholder->save();


        }
        $user = Stakeholder::where('nama', $request->nama)->first();
        if ($user) {
            if (Auth::guard('stakeholder')->attempt([
                'nama' => $user->nama,
                'password'=> $user->nama_instansi])) {
                //redirect jika sukses login
                Auth::login($user);
                session(['stakeholder' => true]);

                //ambil data kuesioner
                $kuesioners = tb_kuesioner_stakeholder::where('id_prodi', $request->prodi)
                    ->whereRaw('id_tahun_periode = (select max(`id_tahun_periode`) from tb_kuesioner_stakeholder)')->get();
                $opsi = tb_opsi_stakeholder::get();
                return view('/stakeholder/kuesioner', compact('kuesioners', 'opsi'))->with('success', 'Berhasil registrasi, silakan menjawab kuesioner');
            } else {
                //redirect jika gagal login
                return redirect()->back()->with('error', 'Gagal registrasi');
            }
        }else{
            return redirect()->back()->with('error', 'Gagal registrasi');
        }
    }

    public function logout(Request $request){
        $request->session()->flush();
        return redirect('/stakeholder');
    }
}

