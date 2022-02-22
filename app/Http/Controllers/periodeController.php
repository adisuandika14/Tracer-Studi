<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tb_periode;
use Illuminate\Support\Facades\Validator;

class periodeController extends Controller
{
    public function show(){
        $periode = tb_periode::orderBy('periode','asc')->get();

        return view ('/admin/masterperiode',compact('periode'));
    }

    public function create(Request $request){
        $cek_priode = tb_periode::where('periode', $request->periode)->first();
        if($cek_priode != ''){
            return back()->with('error', 'Data yang dimasukkan sudah terdaftar');
        }

        $periode = new tb_periode();
        $periode->periode = $request->periode;
        $periode->save();

        return redirect('/admin/periode')->with('sukses','Data Berhasil ditambahkan');
    }

    public function update(Request $request){
        $cek_priode = tb_periode::where('periode', $request->periode)->first();
        if($cek_priode != ''){
            return back()->with('error', 'Data yang dimasukkan sudah terdaftar');
        }
        $res = NULL;
        $updatedata = tb_periode::find($request->id_periode);
        $updatedata->periode = $request->periode;
        $updatedata->update();
        return back()->with('sukses','Data Berhasil diperbaharui');
    }

    public function delete($id){
        $deletedata = tb_periode::find($id);
        $deletedata->delete();
        return back()->with('syjses','Data Berhasil diperbaharui');
    }
}
