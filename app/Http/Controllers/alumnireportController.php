<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\tb_jawaban;
use App\tb_alumni;
use App\tb_prodi;
use App\tb_angkatan;
use App\tb_periode;


class alumnireportController extends Controller
{
    public function tracer(){
        $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
        $tracers = tb_alumni::with('relasiAlumnitoProdi')->whereIn('id_alumni', $all_jawaban)->get();
        $prodi = tb_prodi::get();
        $angkatan = tb_angkatan::get();
        $periode = tb_periode::get();
        return view ('/report/reportalumni', compact('tracers', 'prodi', 'angkatan','periode'));
    }

    public function detailtracer($id){
        $alumni = tb_alumni::where('id_alumni', $id)->first();
        $jawaban = tb_jawaban::with('relasiJawabantoDetail')->where('id_alumni', $alumni->id_alumni)->get();

        //dd($detailjawaban);
        return view ('/report/detail-tracer', compact('alumni', 'jawaban'));
    }

    public function filtertracer(Request $request){
        if($request->prodi == "" && $request->angkatan == ""){
            return redirect ('/admin/reportalumni');
        }else if($request->prodi == "" && $request->angkatan != ""){
            $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
            $tracers = tb_alumni::with('relasiAlumnitoProdi')->whereIn('id_alumni', $all_jawaban)->where('id_angkatan', $request->angkatan)->get();
            $prodi = tb_prodi::get();
            $angkatan = tb_angkatan::get();
            $id_angkatan = $request->angkatan;
            return view ('/report/reportalumni', compact('tracers', 'prodi', 'angkatan', 'id_angkatan'));
        }else if($request->prodi != "" && $request->angkatan == ""){
            $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
            $tracers = tb_alumni::with('relasiAlumnitoProdi')->whereIn('id_alumni', $all_jawaban)->where('id_prodi', $request->prodi)->get();
            $prodi = tb_prodi::get();
            $angkatan = tb_angkatan::get();
            $id_prodi = $request->prodi;
            return view ('/report/reportalumni', compact('tracers', 'prodi', 'angkatan', 'id_prodi'));
        }else if($request->prodi != "" && $request->angkatan != ""){
            $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
            $tracers = tb_alumni::with('relasiAlumnitoProdi')->whereIn('id_alumni', $all_jawaban)->where('id_prodi', $request->prodi)->where('id_angkatan', $request->angkatan)->get();
            $prodi = tb_prodi::get();
            $angkatan = tb_angkatan::get();
            $id_angkatan = $request->angkatan;
            $id_prodi = $request->prodi;
            return view ('/report/reportalumni', compact('tracers', 'prodi', 'angkatan', 'id_prodi', 'id_angkatan'));
        }



        $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
        $tracers = tb_alumni::with('relasiAlumnitoProdi')->whereIn('id_alumni', $all_jawaban)->get();
        $prodi = tb_prodi::get();
        $angkatan = tb_angkatan::get();
        return view ('/report/reportalumni', compact('tracers', 'prodi', 'angkatan'));
    }
}
