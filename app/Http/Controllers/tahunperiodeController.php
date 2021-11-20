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
        tb_tahun_periode::create([
            'tahun_periode'=>$request->tahun_periode,
        ]);

        return redirect('/admin/mastertahun')->with('sukses','Data Berhasil ditambahkan');
    }

    public function update(Request $request){
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
