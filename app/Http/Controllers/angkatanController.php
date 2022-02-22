<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\tb_angkatan;
use Illuminate\Support\Facades\Validator;

class angkatanController extends Controller
{
    public function show(){
        $angkatan = tb_angkatan::orderBy('tahun_angkatan','asc')->where('deleted_at',NULL)->get();
            return view('/admin/masterangkatan', compact ('angkatan'));
        }
    

    public function create(Request $request){
        $cek_angkatan = tb_angkatan::where('tahun_angkatan', $request->tahun_angkatan)->first();
        if($cek_angkatan != ''){
            return back()->with('error', 'Data yang dimasukkan sudah terdaftar');
        }

        $tahun_angkatan = new tb_angkatan();
        $tahun_angkatan->tahun_angkatan = $request->tahun_angkatan;
        $tahun_angkatan->save();
        return redirect('/admin/angkatan')->with('sukses','Data berhasil diperbaharui!');
    }

    public function delete($id){
        $deletedata = tb_angkatan::find($id);
        $deletedata->delete();
        return redirect('/admin/angkatan')->with('sukses','Data berhasil dihapus!');
    }

    public function update(Request $request){
        $cek_angkatan = tb_angkatan::where('tahun_angkatan', $request->tahun_angkatan)->first();
        if($cek_angkatan != ''){
            return back()->with('error', 'Data yang dimasukkan sudah terdaftar');
        }
        
        $res = NULL;
        $updatedata = tb_angkatan::find($request->id_angkatan);
        $updatedata->tahun_angkatan = $request->tahun_angkatan;
        $updatedata->update();
        //dd($updatedata);
        return redirect('/admin/angkatan')->with('sukses','Data berhasil diperbaharui!');
    }
    
}
