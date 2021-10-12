<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\tb_periode_kuesioner;
use App\tb_tahun_periode;
use App\tb_periode;

class kuesionerperiodeController extends Controller
{
    public function show(){
        $periode = tb_periode_kuesioner::get();
        $tahun = tb_tahun_periode::get();
        $periodekuesioner = tb_periode::get();


        return view('kuesioner/periodekuesioner', compact('periode','tahun','periodekuesioner'));
    }


    public function create(Request $request){

        $periodekuesioner = new tb_periode_kuesioner;
        $periodekuesioner->id_tahun_periode = $request->id_tahun_periode;
        $periodekuesioner->id_periode = $request->id_periode;
        $periodekuesioner->save();

        return redirect('/admin/periodekuesioner')->with('statusInpput','Data Berhasil ditambahkan');
    }

    public function update(Request $request){
        $res = NULL;
        $updatedata = tb_periode_kuesioner::find($request->id_periode_kuesioner);
        $periodekuesioner->id_tahun_periode = $request->id_tahun_periode;
        $periodekuesioner->id_periode = $request->id_periode;
        $updatedata->update();
        return back()->with('statusInput','Data Berhasil diperbaharui');
    }

    public function delete($id){
        $deletedata = tb_periode_kuesioner::find($id);
        $deletedata->delete();
        return back()->with('statusInput','Data Berhasil diperbaharui');
    }

}
