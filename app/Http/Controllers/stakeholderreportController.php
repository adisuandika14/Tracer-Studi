<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\tb_jawaban_stakeholder;
use App\tb_stakeholder;
use App\tb_prodi;
use App\tb_periode_kuesioner;

class stakeholderreportController extends Controller
{
    public function report(){
        $all_jawaban = tb_jawaban_stakeholder::get(['id_stakeholder'])->toArray();
        $tracers = tb_stakeholder::with('relasiStackholderKuesionertoProdi')->whereIn('id_stakeholder', $all_jawaban)->get();
        $prodi = tb_prodi::get();
        $stakeholder = tb_stakeholder::get();
        $periode = tb_periode_kuesioner::get();
        foreach($periode as $ang){
            $data = $stakeholder->where('id_periode', $ang->id_periode_kuesioner)->count('id_stakeholder');
            // dd($ang->tahun_angkatan." ".$alumni);
            $dataStakeholder[] = $data;
            $dataPeriode[] = $ang->relasiPeriodekuesionertoPeriode->periode.' - '.$ang->relasiPeriodekuesionertoTahun->tahun_periode;
        }
        return view ('report/reportstakeholder', compact('tracers', 'prodi','periode','stakeholder','dataStakeholder','dataPeriode'));
    }

    public function detailreport($id){
        $stakeholder = tb_stakeholder::where('id_stakeholder', $id)->first();
        $jawaban = tb_jawaban_stakeholder::where('id_stakeholder', $stakeholder->id_stakeholder)->get();

        return view ('/report/detailreportstakeholder', compact('stakeholder', 'jawaban'));
    }

    public function filterreport(Request $request){
        if($request->prodi == "" && $request->periode == ""){
            return redirect ('/admin/reportstakeholder');
        }else if($request->prodi == "" && $request->periode != ""){
            $all_jawaban = tb_jawaban_stakeholder::get(['id_stakeholder'])->toArray();
            $stakeholder = tb_stakeholder::with('relasiStackholderKuesionertoProdi')->where('id_periode', $request->periode)->get();
            $prodi = tb_prodi::get();
            $periode = tb_periode_kuesioner::get();
            $id_periode = $request->periode_kuesioner;
            foreach($periode as $ang){
                $data = $stakeholder->where('id_periode', $ang->id_periode_kuesioner)->count('id_stakeholder');
                // dd($ang->tahun_angkatan." ".$alumni);
                $dataStakeholder[] = $data;
                $dataPeriode[] = $ang->relasiPeriodekuesionertoPeriode->periode.' - '.$ang->relasiPeriodekuesionertoTahun->tahun_periode;
            }
            return view ('/report/reportstakeholder', compact('stakeholder', 'prodi', 'periode', 'id_periode','dataStakeholder','dataPeriode'));
        }else if($request->prodi != "" && $request->periode_kuesioner == ""){
            $all_jawaban = tb_jawaban_stakeholder::get(['id_stakeholder'])->toArray();
            $stakeholder = tb_stakeholder::with('relasiStackholderKuesionertoProdi')->where('id_prodi', $request->prodi)->get();
            $prodi = tb_prodi::get();
            $periode = tb_periode_kuesioner::get();
            $id_prodi = $request->prodi;
            foreach($periode as $ang){
                $data = $stakeholder->where('id_periode', $ang->id_periode_kuesioner)->count('id_stakeholder');
                // dd($ang->tahun_angkatan." ".$alumni);
                $dataStakeholder[] = $data;
                $dataPeriode[] = $ang->relasiPeriodekuesionertoPeriode->periode.' - '.$ang->relasiPeriodekuesionertoTahun->tahun_periode;
            }
            return view ('/report/reportstakeholder', compact('stakeholder', 'prodi', 'periode', 'id_prodi','dataStakeholder','dataPeriode'));
        }else if($request->prodi != "" && $request->periode_kuesioner != ""){
            $all_jawaban = tb_jawaban_stakeholder::get(['id_stakeholder'])->toArray();
            $stakeholder = tb_stakeholder::with('relasiStackholderKuesionertoProdi')->where('id_prodi', $request->prodi)->where('id_periode', $request->periode)->get();
            $prodi = tb_prodi::get();
            $periode = tb_periode_kuesioner::get();
            $id_periode = $request->periode_kuesioner;
            $id_prodi = $request->prodi;
            foreach($periode as $ang){
                $data = $stakeholder->where('id_periode', $ang->id_periode_kuesioner)->count('id_stakeholder');
                // dd($ang->tahun_angkatan." ".$alumni);
                $dataStakeholder[] = $data;
                $dataPeriode[] = $ang->relasiPeriodekuesionertoPeriode->periode.' - '.$ang->relasiPeriodekuesionertoTahun->tahun_periode;
            }
            return view ('/report/reportstakeholder', compact('stakeholder', 'prodi', 'periode', 'id_prodi', 'id_periode','dataStakeholder','dataPeriode'));
        }

        $all_jawaban = tb_jawaban_stakeholder::get(['id_stakeholder'])->toArray();
        $stakeholder = tb_stakeholder::with('relasiStackholderKuesionertoProdi')->get();
        $prodi = tb_prodi::get();
        $periode = tb_periode_kuesioner::get();
        foreach($periode as $ang){
            $data = $stakeholder->where('id_periode', $ang->id_periode_kuesioner)->count('id_stakeholder');
            // dd($ang->tahun_angkatan." ".$alumni);
            $dataStakeholder[] = $data;
            $dataPeriode[] = $ang->relasiPeriodekuesionertoPeriode->periode.' - '.$ang->relasiPeriodekuesionertoTahun->tahun_periode;
        }
        return view ('report/reportstakeholder', compact('stakeholder', 'prodi', 'periode','dataStakeholder','dataPeriode'));
    }
}
