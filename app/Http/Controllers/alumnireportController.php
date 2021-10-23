<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\tb_jawaban;
use App\tb_alumni;
use App\tb_prodi;
use App\tb_angkatan;
use App\tb_periode;
use App\tb_kuesioner;
use App\tb_soal_alumni;
use App\tb_detail_kuesioner;
use App\tb_tahun_periode;
use DB;


class alumnireportController extends Controller
{
    public function tracer(){
        $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
        $tracers = tb_alumni::with('relasiAlumnitoProdi')->whereIn('id_alumni', $all_jawaban)->get();
        $kategori_1 = tb_soal_alumni::all();
        // $kategori_2 = tb_soal_alumni::all();
        $prodi = tb_prodi::get();
        $angkatan = tb_angkatan::orderBy('tahun_angkatan','asc')->get();
        $tahun_wisuda = tb_alumni::select(DB::raw('YEAR(tahun_wisuda) as tahun_wisuda'))->distinct()->get();
        $tahun_periode = tb_tahun_periode::all();
        // dd($tahunWisuda);
        $periode = tb_periode::get();
        foreach($angkatan as $ang){
            $alumni = $tracers->where('id_angkatan', $ang->id_angkatan)->count('id_alumni', 'tahun');
            // dd($ang->tahun_angkatan." ".$alumni);
            $dataAngkatan[] = $alumni;
            $tahunAngkatan[] = $ang->tahun_angkatan;
        }
        foreach ($prodi as $p){
            $ps = $tracers->where('id_prodi',$p->id_prodi)->count('id_alumni','tahun');
            $dataProdi[] = $ps;
            $namaProdi[] = $p->nama_prodi;
        }
        return view ('/report/reportalumni', compact('tracers', 'prodi', 'angkatan','periode', 'kategori_1', 'dataAngkatan', 'dataProdi', 'tahunAngkatan','namaProdi', 'tahun_wisuda', 'tahun_periode'));
    }

    public function detailtracer($id){
        $alumni = tb_alumni::where('id_alumni', $id)->first();
        $jawaban = tb_jawaban::with('relasiJawabantoDetail')->where('id_alumni', $alumni->id_alumni)->get();

        //dd($detailjawaban);
        return view ('/report/detail-tracer', compact('alumni', 'jawaban'));
    }

    public function filtertracer(Request $request){
        $data = [];
        if($request->prodi == "" && $request->angkatan == "" && $request->kategori_1 == ""){
            if($request->tahun_wisuda != ""){
                if($request->tahun_periode != ""){
                    if($request->periode != ""){

                    }else{

                    }
                }else{
                    if($request->periode != ""){

                    }else{

                    }
                }
            }else{
                if($request->tahun_periode != ""){
                    if($request->periode != ""){

                    }else{

                    }
                }else{
                    if($request->periode != ""){

                    }else{
                        $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereIn('id_alumni', $all_jawaban)->get();
                        $prodi = tb_prodi::get();
                        $angkatan = tb_angkatan::get();
                        $periode = tb_periode::get();
                        $angkatan = tb_angkatan::all();
                        foreach($angkatan as $ang){
                            $alumni = $tracers->where('id_angkatan', $ang->id_angkatan)->count('id_alumni', 'tahun');
                            // dd($ang->tahun_angkatan." ".$alumni);
                            $dataAlumni[] = $alumni;
                            $tahun[] = $ang->tahun_angkatan;
                        }
                        foreach ($prodi as $p){
                            $ps = $tracers->where('id_prodi',$p->id_prodi)->count('id_alumni','tahun');
                            $dataProdi[] = $ps;
                            $namaProdi[] = $p->nama_prodi;
                        }
                        $data['label_data_angkatan'] = $dataAlumni;
                        $data['label_angkatan'] = $tahun;
                        $data['label_data_prodi'] = $dataProdi;
                        $data['label_prodi'] = $namaProdi;
                        $data['all_jawaban'] = $all_jawaban;
                        $data['tracers'] = $tracers;
                        $data['prodi'] = $prodi;
                        $data['angkatan'] = $angkatan;
                        // $data['id_angkatan'] = $id_angkatan;
                        return response()->json($data, 200);
                        // return redirect ('/admin/reportalumni');
                    }
                }
            }
        }else if($request->prodi != "" && $request->angkatan == "" && $request->kategori_1 == "" ){
            if($request->tahun_wisuda != ""){
                if($request->tahun_periode != ""){
                    if($request->periode != ""){

                    }else{

                    }
                }else{
                    if($request->periode != ""){

                    }else{

                    }
                }
            }else{
                if($request->tahun_periode != ""){
                    if($request->periode != ""){

                    }else{

                    }
                }else{
                    if($request->periode != ""){

                    }else{
                        $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereIn('id_alumni', $all_jawaban)->where('id_prodi', $request->prodi)->get();
                        $prodi = tb_prodi::get();
                        $angkatan = tb_angkatan::get();
                        $id_prodi = $request->prodi;
                        $angkatan = tb_angkatan::all();
                        foreach($angkatan as $ang){
                            $alumni = $tracers->where('id_angkatan', $ang->id_angkatan)->count('id_alumni', 'tahun');
                            // dd($ang->tahun_angkatan." ".$alumni);
                            $dataAlumni[] = $alumni;
                            $tahun[] = $ang->tahun_angkatan;
                        }
                        foreach ($prodi as $p){
                            $ps = $tracers->where('id_prodi',$p->id_prodi)->count('id_alumni','tahun');
                            $dataProdi[] = $ps;
                            $namaProdi[] = $p->nama_prodi;
                        }
                        $data['label_data_angkatan'] = $dataAlumni;
                        $data['label_angkatan'] = $tahun;
                        $data['label_data_prodi'] = $dataProdi;
                        $data['label_prodi'] = $namaProdi;
                        $data['all_jawaban'] = $all_jawaban;
                        $data['tracers'] = $tracers;
                        $data['prodi'] = $prodi;
                        $data['angkatan'] = $angkatan;
                        // $data['id_angkatan'] = [$id_angkatan];
                        return response()->json($data, 200);
                    }
                }
            }
            // return view ('/report/reportalumni', compact('tracers', 'prodi', 'angkatan', 'id_prodi'));
        }else if($request->prodi == "" && $request->angkatan != "" && $request->kategori_1 == ""){
            if($request->tahun_wisuda != ""){
                if($request->tahun_periode != ""){
                    if($request->periode != ""){

                    }else{

                    }
                }else{
                    if($request->periode != ""){

                    }else{

                    }
                }
            }else{
                if($request->tahun_periode != ""){
                    if($request->periode != ""){

                    }else{

                    }
                }else{
                    if($request->periode != ""){

                    }else{
                        $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereIn('id_alumni', $all_jawaban)->where('id_angkatan', $request->angkatan)->get();
                        $prodi = tb_prodi::get();
                        $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $angkatan = tb_angkatan::all();
                        foreach($angkatan as $ang){
                            $alumni = $tracers->where('id_angkatan', $ang->id_angkatan)->count('id_alumni', 'tahun');
                            // dd($ang->tahun_angkatan." ".$alumni);
                            $dataAlumni[] = $alumni;
                            $tahun[] = $ang->tahun_angkatan;
                        }
                        foreach ($prodi as $p){
                            $ps = $tracers->where('id_prodi',$p->id_prodi)->count('id_alumni','tahun');
                            $dataProdi[] = $ps;
                            $namaProdi[] = $p->nama_prodi;
                        }
                        $data['label_data_angkatan'] = $dataAlumni;
                        $data['label_angkatan'] = $tahun;
                        $data['label_data_prodi'] = $dataProdi;
                        $data['label_prodi'] = $namaProdi;
                        $data['all_jawaban'] = $all_jawaban;
                        $data['tracers'] = $tracers;
                        $data['prodi'] = $prodi;
                        $data['angkatan'] = $angkatan;
                        $data['id_angkatan'] = $id_angkatan;
                        return response()->json($data, 200);
                    }
                }
            }
            // return view ('/report/reportalumni', compact('tracers', 'prodi', 'angkatan', 'id_angkatan'));
        }else if($request->prodi == "" && $request->angkatan == "" && $request->kategori_1 != ""){
            if($request->tahun_wisuda != ""){
                if($request->tahun_periode != ""){
                    if($request->periode != ""){

                    }else{

                    }
                }else{
                    if($request->periode != ""){

                    }else{

                    }
                }
            }else{
                if($request->tahun_periode != ""){
                    if($request->periode != ""){

                    }else{

                    }
                }else{
                    if($request->periode != ""){

                    }else{
                        $kuesioner = tb_kuesioner::where('id_bank_soal', $request->kategori_1)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuesioner)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereIn('id_alumni', $all_jawaban)->get();
                        $prodi = tb_prodi::get();
                        $angkatan = tb_angkatan::get();
                        $periode = tb_periode::get();
                        $angkatan = tb_angkatan::all();
                        foreach($angkatan as $ang){
                            $alumni = $tracers->where('id_angkatan', $ang->id_angkatan)->count('id_alumni', 'tahun');
                            // dd($ang->tahun_angkatan." ".$alumni);
                            $dataAlumni[] = $alumni;
                            $tahun[] = $ang->tahun_angkatan;
                        }
                        foreach ($prodi as $p){
                            $ps = $tracers->where('id_prodi',$p->id_prodi)->count('id_alumni','tahun');
                            $dataProdi[] = $ps;
                            $namaProdi[] = $p->nama_prodi;
                        }
                        $data['label_data_angkatan'] = $dataAlumni;
                        $data['label_angkatan'] = $tahun;
                        $data['label_data_prodi'] = $dataProdi;
                        $data['label_prodi'] = $namaProdi;
                        $data['all_jawaban'] = $all_jawaban;
                        $data['tracers'] = $tracers;
                        $data['prodi'] = $prodi;
                        $data['angkatan'] = $angkatan;
                        // $data['id_angkatan'] = $id_angkatan;
                        return response()->json($data, 200);
                    }
                }
            }
            // return view ('/report/reportalumni', compact('tracers', 'prodi', 'angkatan', 'id_angkatan'));
        }else if($request->prodi != "" && $request->angkatan != "" && $request->kategori_1 == ""){
            if($request->tahun_wisuda != ""){
                if($request->tahun_periode != ""){
                    if($request->periode != ""){

                    }else{

                    }
                }else{
                    if($request->periode != ""){

                    }else{

                    }
                }
            }else{
                if($request->tahun_periode != ""){
                    if($request->periode != ""){

                    }else{

                    }
                }else{
                    if($request->periode != ""){

                    }else{
                        $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereIn('id_alumni', $all_jawaban)->where('id_prodi', $request->prodi)->where('id_angkatan', $request->angkatan)->get();
                        $prodi = tb_prodi::get();
                        $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $id_prodi = $request->prodi;
                        $angkatan = tb_angkatan::all();
                        foreach($angkatan as $ang){
                            $alumni = $tracers->where('id_angkatan', $ang->id_angkatan)->count('id_alumni', 'tahun');
                            // dd($ang->tahun_angkatan." ".$alumni);
                            $dataAlumni[] = $alumni;
                            $tahun[] = $ang->tahun_angkatan;
                        }
                        foreach ($prodi as $p){
                            $ps = $tracers->where('id_prodi',$p->id_prodi)->count('id_alumni','tahun');
                            $dataProdi[] = $ps;
                            $namaProdi[] = $p->nama_prodi;
                        }
                        $data['label_data_angkatan'] = $dataAlumni;
                        $data['label_angkatan'] = $tahun;
                        $data['label_data_prodi'] = $dataProdi;
                        $data['label_prodi'] = $namaProdi;
                        $data['all_jawaban'] = $all_jawaban;
                        $data['tracers'] = $tracers;
                        $data['prodi'] = $prodi;
                        $data['angkatan'] = $angkatan;
                        $data['id_angkatan'] = $id_angkatan;
                        $data['id_prodi'] = $id_prodi;
                        return response()->json($data, 200);
                    }
                }
            }
            // return response()->json();
            // return view ('/report/reportalumni', compact('tracers', 'prodi', 'angkatan', 'id_prodi', 'id_angkatan'));
        }else if($request->prodi != "" && $request->angkatan == "" && $request->kategori_1 != ""){
            if($request->tahun_wisuda != ""){
                if($request->tahun_periode != ""){
                    if($request->periode != ""){

                    }else{

                    }
                }else{
                    if($request->periode != ""){

                    }else{

                    }
                }
            }else{
                if($request->tahun_periode != ""){
                    if($request->periode != ""){

                    }else{

                    }
                }else{
                    if($request->periode != ""){

                    }else{
                        $kuesioner = tb_kuesioner::where('id_bank_soal', $request->kategori_1)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuesioner)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        // $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereIn('id_alumni', $all_jawaban)->where('id_prodi', $request->prodi)->get();
                        $prodi = tb_prodi::get();
                        $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $id_prodi = $request->prodi;
                        $angkatan = tb_angkatan::all();
                        foreach($angkatan as $ang){
                            $alumni = $tracers->where('id_angkatan', $ang->id_angkatan)->count('id_alumni', 'tahun');
                            // dd($ang->tahun_angkatan." ".$alumni);
                            $dataAlumni[] = $alumni;
                            $tahun[] = $ang->tahun_angkatan;
                        }
                        foreach ($prodi as $p){
                            $ps = $tracers->where('id_prodi',$p->id_prodi)->count('id_alumni','tahun');
                            $dataProdi[] = $ps;
                            $namaProdi[] = $p->nama_prodi;
                        }
                        $data['label_data_angkatan'] = $dataAlumni;
                        $data['label_angkatan'] = $tahun;
                        $data['label_data_prodi'] = $dataProdi;
                        $data['label_prodi'] = $namaProdi;
                        $data['all_jawaban'] = $all_jawaban;
                        $data['tracers'] = $tracers;
                        $data['prodi'] = $prodi;
                        $data['angkatan'] = $angkatan;
                        $data['id_angkatan'] = $id_angkatan;
                        $data['id_prodi'] = $id_prodi;
                        return response()->json($data, 200);
                    }
                }
            }
            // return response()->json();
            // return view ('/report/reportalumni', compact('tracers', 'prodi', 'angkatan', 'id_prodi', 'id_angkatan'));
        }else if($request->prodi == "" && $request->angkatan != "" && $request->kategori_1 != ""){
            if($request->tahun_wisuda != ""){
                if($request->tahun_periode != ""){
                    if($request->periode != ""){

                    }else{

                    }
                }else{
                    if($request->periode != ""){

                    }else{

                    }
                }
            }else{
                if($request->tahun_periode != ""){
                    if($request->periode != ""){

                    }else{

                    }
                }else{
                    if($request->periode != ""){

                    }else{
                        $kuesioner = tb_kuesioner::where('id_bank_soal', $request->kategori_1)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuesioner)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereIn('id_alumni', $all_jawaban)->where('id_angkatan', $request->angkatan)->get();
                        $prodi = tb_prodi::get();
                        $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $angkatan = tb_angkatan::all();
                        foreach($angkatan as $ang){
                            $alumni = $tracers->where('id_angkatan', $ang->id_angkatan)->count('id_alumni', 'tahun');
                            // dd($ang->tahun_angkatan." ".$alumni);
                            $dataAlumni[] = $alumni;
                            $tahun[] = $ang->tahun_angkatan;
                        }
                        foreach ($prodi as $p){
                            $ps = $tracers->where('id_prodi',$p->id_prodi)->count('id_alumni','tahun');
                            $dataProdi[] = $ps;
                            $namaProdi[] = $p->nama_prodi;
                        }
                        $data['label_data_angkatan'] = $dataAlumni;
                        $data['label_angkatan'] = $tahun;
                        $data['label_data_prodi'] = $dataProdi;
                        $data['label_prodi'] = $namaProdi;
                        $data['all_jawaban'] = $all_jawaban;
                        $data['tracers'] = $tracers;
                        $data['prodi'] = $prodi;
                        $data['angkatan'] = $angkatan;
                        $data['id_angkatan'] = $id_angkatan;
                        return response()->json($data, 200);
                    }
                }
            }
            // return view ('/report/reportalumni', compact('tracers', 'prodi', 'angkatan', 'id_angkatan'));
        }else if($request->prodi != "" && $request->angkatan != "" && $request->kategori_1 != ""){
            if($request->tahun_wisuda != ""){
                if($request->tahun_periode != ""){
                    if($request->periode != ""){

                    }else{

                    }
                }else{
                    if($request->periode != ""){

                    }else{

                    }
                }
            }else{
                if($request->tahun_periode != ""){
                    if($request->periode != ""){

                    }else{

                    }
                }else{
                    if($request->periode != ""){

                    }else{
                        $kuesioner = tb_kuesioner::where('id_bank_soal', $request->kategori_1)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuesioner)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        // $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereIn('id_alumni', $all_jawaban)->where('id_angkatan', $request->angkatan)->where('id_prodi', $request->prodi)->get();
                        $prodi = tb_prodi::get();
                        $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $angkatan = tb_angkatan::all();
                        foreach($angkatan as $ang){
                            $alumni = $tracers->where('id_angkatan', $ang->id_angkatan)->count('id_alumni', 'tahun');
                            // dd($ang->tahun_angkatan." ".$alumni);
                            $dataAlumni[] = $alumni;
                            $tahun[] = $ang->tahun_angkatan;
                        }
                        foreach ($prodi as $p){
                            $ps = $tracers->where('id_prodi',$p->id_prodi)->count('id_alumni','tahun');
                            $dataProdi[] = $ps;
                            $namaProdi[] = $p->nama_prodi;
                        }
                        $data['label_data_angkatan'] = $dataAlumni;
                        $data['label_angkatan'] = $tahun;
                        $data['label_data_prodi'] = $dataProdi;
                        $data['label_prodi'] = $namaProdi;
                        $data['all_jawaban'] = $all_jawaban;
                        $data['tracers'] = $tracers;
                        $data['prodi'] = $prodi;
                        $data['angkatan'] = $angkatan;
                        $data['id_angkatan'] = $id_angkatan;
                        return response()->json($data, 200);
                    }
                }
            }
            // return view ('/report/reportalumni', compact('tracers', 'prodi', 'angkatan', 'id_angkatan'));
        }

        $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereIn('id_alumni', $all_jawaban)->get();
        $prodi = tb_prodi::get();
        $angkatan = tb_angkatan::get();
        return view ('/report/reportalumni', compact('tracers', 'prodi', 'angkatan'));
    }
}
