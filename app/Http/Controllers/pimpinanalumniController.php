<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\tb_alumni;
use App\tb_angkatan;
use App\tb_kota;
use App\tb_provinsi;
use App\tb_prodi;
use App\tb_gender;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;

use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
class pimpinanalumniController extends Controller
{
    public function show(){

        $alumni = tb_alumni::with('relasiAlumnitoAngkatan','relasiAlumnitoProdi','relasiAlumnitoGender')->get();
        //$alumni = tb_alumni::all();
        $prodi = tb_prodi::all();
        $gender = tb_gender::all();
        $angkatan = tb_angkatan::all();
        //$kota = tb_kota::all();
        //$provinsi = tb_provinsi::all();
    
        $province = Province::all();
        $regencies = Regency::all();
        $districts = District::all();
        $villages = Village::all();
  
            return view('/pimpinan/alumni/dataalumni', compact ('alumni','prodi','angkatan','gender','province','regencies','districts','villages'));
        }
    
        public function create(Request $request){
    
                tb_alumni::create([
                    'nama_alumni'=>$request->nama_alumni,
                    'id_gender'=>$request->id_gender,
                    'alamat_alumni'=>$request->alamat_alumni,
                    'id_prodi'=>$request->id_prodi,
                    'id_angkatan'=>$request->id_angkatan,
                    'email_alumni'=>$request->email_alumni,
                    'no_hp'=>$request->no_hp,
                    'id_line'=>$request->id_line,
                    'id_telegram'=>$request->id_telegram,
                    'tahun_lulus'=>$request->tahun_lulus,
                    'tahun_wisuda'=>$request->tahun_wisuda,
                    ]);
                return redirect('/pimpinan/alumni')->with('success','Data berhasil disimpan!');
    
        }
    
        public function delete($id){
            $deletedata = tb_alumni::find($id);
            $deletedata->delete();
            return redirect('/pimpinan/alumni')->with('success','Data berhasil dihapus!');
        }
    
        public function update(Request $request){
            $res = NULL;
            $updatedata = tb_alumni::find($request->id_alumni);
            $updatedata->nama_alumni = $request->nama_alumni;
            $updatedata->id_gender = $request->id_gender;
            $updatedata->id_prodi = $request->id_prodi;
            $updatedata->id_angkatan = $request->id_angkatan;
            $updatedata->alamat_alumni = $request->alamat_alumni;
            $updatedata->email_alumni = $request->email_alumni;
            $updatedata->no_hp = $request->no_hp;
            $updatedata->id_line = $request->id_line;
            $updatedata->id_telegram = $request->id_telegram;
            $updatedata->tahun_lulus = $request->tahun_lulus;
            $updatedata->tahun_wisuda = $request->tahun_wisuda;
            $updatedata->update();
            //dd($updatedata);
           return redirect('/pimpinan/alumni')->with('success','Data berhasil diupdate!');
        }
}
