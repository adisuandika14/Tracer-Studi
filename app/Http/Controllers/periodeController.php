<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tb_periode;
use Illuminate\Support\Facades\Validator;

class periodeController extends Controller
{
    public function show(){
        $periode = tb_periode::get();

        return view ('/admin/masterperiode',compact('periode'));
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'periode' => 'required|unique:tb_periode,periode',
        ],[
             'periode.required' => "Anda Belum Menambahkan Periode",
             'periode.unique' => "Periode yang dimasukkan sudah Terdaftar",
         ]);

        if($validator->fails()){
            return back()->withErrors($validator);
        }

        tb_periode::create([
            'periode'=>$request->periode,
        ]);

        return redirect('/admin/periode')->with('sukses','Data Berhasil ditambahkan');
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'periode' => 'required|unique:tb_periode,periode',
        ],[
             'periode.required' => "Anda Belum Menambahkan Periode",
             'periode.unique' => "Periode yang dimasukkan sudah Terdaftar",
         ]);

        if($validator->fails()){
            return back()->withErrors($validator);
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
