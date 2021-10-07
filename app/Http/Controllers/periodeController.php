<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tb_periode;

class periodeController extends Controller
{
    public function show(){
        $periode = tb_periode::get();

        return view ('/admin/masterperiode',compact('periode'));
    }

    public function create(Request $request){
        tb_periode::create([
            'periode'=>$request->periode,
        ]);

        return redirect('/admin/periode')->with('statusInpput','Data Berhasil ditambahkan');
    }

    public function update(Request $request){
        $res = NULL;
        $updatedata = tb_periode::find($request->id_periode);
        $updatedata->periode = $request->periode;
        $updatedata->update();
        return back()->with('statusInput','Data Berhasil diperbaharui');
    }

    public function delete($id){
        $deletedata = tb_periode::find($id);
        $deletedata->delete();
        return back()->with('statusInput','Data Berhasil diperbaharui');
    }
}
