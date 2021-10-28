<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\tb_periode_kuesioner;
use App\tb_tahun_periode;
use App\tb_periode;
use Illuminate\Support\Facades\Validator;

class kuesionerperiodeController extends Controller
{
    public function show(){
        $periode = tb_periode_kuesioner::get();
        $tahun = tb_tahun_periode::get();
        $periodekuesioner = tb_periode::get();


        return view('kuesioner/periodekuesioner', compact('periode','tahun','periodekuesioner'));
    }


    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'id_tahun_periode' => 'required',
            'id_periode' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
        ],[
             'id_tahun_periode.required' => "Tahun wajib diisi",
             'id_periode.required' => "Periode wajib diisi",
             'tanggal_mulai.required' => "Tanggal Mulai wajib diisi",
             'tanggal_selesai.required' => "Tanggal Selesai wajib diisi",
         ]);

        if($validator->fails()){
            return back()->withErrors($validator);
        }
        $periodekuesioner = new tb_periode_kuesioner;
        $periodekuesioner->id_tahun_periode = $request->id_tahun_periode;
        $periodekuesioner->id_periode = $request->id_periode;
        $periodekuesioner->tanggal_mulai = $request->tanggal_mulai;
        $periodekuesioner->tanggal_selesai = $request->tanggal_selesai;
        $periodekuesioner->status = "Tidak Aktif";
        $periodekuesioner->save();

        return redirect('/admin/periodekuesioner')->with('sukses','Data Berhasil ditambahkan');
    }

    public function update(Request $request){
        $res = NULL;
        $validator = Validator::make($request->all(), [
            'id_tahun_periode' => 'required',
            'id_periode' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
        ],[
             'id_tahun_periode.required' => "Tahun wajib diisi",
             'id_periode.required' => "Periode wajib diisi",
             'tanggal_mulai.required' => "Tanggal Mulai wajib diisi",
             'tanggal_selesai.required' => "Tanggal Selesai wajib diisi",
         ]);

        $updatedata = tb_periode_kuesioner::find($request->id_periode_kuesioner);
        $updatedata->id_tahun_periode = $request->id_tahun_periode;
        $updatedata->id_periode = $request->id_periode;
        $updatedata->tanggal_mulai = $request->tanggal_mulai;
        $updatedata->tanggal_selesai = $request->tanggal_selesai;
        $updatedata->update();
        return back()->with('sukses','Data Berhasil diperbaharui');
    }

    public function delete($id){
        

        $deletedata = tb_periode_kuesioner::where('id_periode_kuesioner', $id);
        $deletedata->delete();

        return back()->with('sukses','Data Berhasil dihapus');
    }

    public function status($id, $status)
    {
        $statusinput = tb_periode_kuesioner::where('id_periode_kuesioner', $id)->first();
        $statusinput->status = $status;
        $statusinput->update();
        return response()->json(['sukses' => 'Status Kuesioner berhasil diganti']);
    }

}
