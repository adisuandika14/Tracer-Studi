<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\tb_jawaban_stakeholder;
use App\tb_stakeholder;
use App\tb_prodi;
use App\tb_tahun_periode;

class pimpinanreportstakeholderController extends Controller
{
    public function report(){
        
       
        $all_jawaban = tb_jawaban_stakeholder::get(['id_stakeholder'])->toArray();
        $tracers = tb_stakeholder::with('relasiStackholderKuesionertoProdi')->whereIn('id_stakeholder', $all_jawaban)->get();
        $prodi = tb_prodi::get();
        $stakeholder = tb_stakeholder::get();
        $periode = tb_tahun_periode::get();
        return view ('pimpinan/stakeholder/reportstakeholder', compact('tracers', 'prodi','periode','stakeholder'));
    }
    public function detailreport($id){
        $stakeholder = tb_stakeholder::where('id_stakeholder', $id)->first();
        $jawaban = tb_jawaban_stakeholder::where('id_stakeholder', $stakeholder->id_stakeholder)->get();

        return view ('pimpinan/stakeholder/detailreport', compact('stakeholder', 'jawaban'));
    }

    public function filterreport(Request $request){
        if($request->prodi == "" && $request->periode == ""){
            return redirect ('/pimpinan/reportstakeholder');
        }else if($request->prodi == "" && $request->angkatan != ""){
            $all_jawaban = tb_jawaban_stakeholder::get(['id_stakeholder'])->toArray();
            $stakeholder = tb_stakeholder::with('relasiStackholderKuesionertoProdi')->whereIn('id_stakeholder', $all_jawaban)->where('id_tahun-periode', $request->periode_kuesioner)->get();
            $prodi = tb_prodi::get();
            $periode = tb_tahun_periode::get();
            $id_periode = $request->periode_kuesioner;
            return view ('/pimpinan/stakeholder/reportstakeholder', compact('stakeholder', 'prodi', 'periode', 'id_periode'));
        }else if($request->prodi != "" && $request->periode_kuesioner == ""){
            $all_jawaban = tb_jawaban_stakeholder::get(['id_stakeholder'])->toArray();
            $stakeholder = tb_stakeholder::with('relasiStackholderKuesionertoProdi')->whereIn('id_stakeholder', $all_jawaban)->where('id_prodi', $request->prodi)->get();
            $prodi = tb_prodi::get();
            $periode = tb_tahun_periode::get();
            $id_prodi = $request->prodi;
            return view ('/pimpinan/stakeholder/reportstakeholder', compact('stakeholder', 'prodi', 'periode', 'id_prodi'));
        }else if($request->prodi != "" && $request->periode_kuesioner != ""){
            $all_jawaban = tb_jawaban_stakeholder::get(['id_stakeholder'])->toArray();
            $stakeholder = tb_stakeholder::with('relasiStackholderKuesionertoProdi')->whereIn('id_stakeholder', $all_jawaban)->where('id_prodi', $request->prodi)->where('id_periode', $request->periode_kuesioner)->get();
            $prodi = tb_prodi::get();
            $periode = tb_tahun_periode::get();
            $id_periode = $request->periode_kuesioner;
            $id_prodi = $request->prodi;
            return view ('/pimpinan/stakeholder/reportstakeholder', compact('stakeholder', 'prodi', 'periode', 'id_prodi', 'id_periode'));
        }



        $all_jawaban = tb_jawaban_stakeholder::get(['id_stakeholder'])->toArray();
        $stakeholder = tb_stakeholder::with('relasiStackholderKuesionertoProdi')->whereIn('id_stakeholder', $all_jawaban)->get();
        $prodi = tb_prodi::get();
        $periode = tb_tahun_periode::get();
        return view ('pimpinan/stakeholder/reportstakeholder', compact('stakeholder', 'prodi', 'periode'));
    }
}
