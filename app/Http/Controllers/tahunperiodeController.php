<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\tb_tahun_periode;

class tahunperiodeController extends Controller
{
    public function show(){
        $periode = tb_tahun_periode::get();

        return view ('/admin/masterdatatahun',compact('periode'));
    }

    public function create(Request $request){
        $cek_tahun = tb_tahun_periode::where('tahun_periode', $request->tahun_periode)->first();
        if($cek_tahun != ''){
            return back()->with('error', 'Data yang dimasukkan sudah terdaftar');
        }
        $tahun = new tb_tahun_periode();
        $tahun->tahun_periode = $request->tahun_periode;
        $tahun->save();

        return redirect('/admin/mastertahun')->with('sukses','Data Berhasil ditambahkan');
    }

    public function update(Request $request){
        $cek_tahun = tb_tahun_periode::where('tahun_periode', $request->tahun_periode)->first();
        if($cek_tahun != ''){
            return back()->with('error', 'Data yang dimasukkan sudah terdaftar');
        }
        $res = NULL;
        $updatedata = tb_tahun_periode::find($request->id_tahun_periode);
        $updatedata->tahun_periode = $request->tahun_periode;
        $updatedata->update();
        return back()->with('sukses','Data Berhasil diperbaharui');
    }

    public function delete($id){

        $deletedata = tb_tahun_periode::find($id);
        $deletedata->delete();
        return back()->with('sukses','Data Berhasil diperbaharui');
    }
}
