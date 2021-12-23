<?php

namespace App\Http\Controllers;

use App\Exports\AlumniExport;
use App\HeadingExcel;
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
use App\tb_periode_kuesioner;
use DB;
use League\CommonMark\Block\Element\Heading;
use Maatwebsite\Excel\Facades\Excel;

class alumnireportController extends Controller
{
    public function tracer(){
        $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
        $tracers = tb_alumni::with('relasiAlumnitoProdi')->whereIn('id_alumni', $all_jawaban)->get();
        $kategori_1 = tb_soal_alumni::all();
        // $kategori_2 = tb_soal_alumni::all();
        $prodi = tb_prodi::get();
        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
        $tahun_wisuda = tb_alumni::select(DB::raw('YEAR(tahun_wisuda) as tahun'))->distinct()->get();
        // dd($tahun_wisuda);
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
    public function array_remove_by_value($array, $value){
        return array_values(array_diff_key($array, array($value)));
    }
    
    public function delete_col(&$array, $key) {
        return array_walk($array, function (&$v) use ($key) {
            unset($v[$key]);
        });
    }

    //
    public function filtertracer(Request $request){


        $data = [];
        
        if($request->prodi == "" && $request->angkatan == "" && $request->kategori_1 == ""){
            if($request->tahun_wisuda != ""){
                if($request->tahun_periode != ""){
                    if($request->periode != ""){
                        
                        $alumniarray = array();
                        $alumniHead = array();
                        $alumniarr = array();
                        $headings = HeadingExcel::get();
                        $default = array('Nama Alumni', 'NIK', 'Nim Alumni','Program Studi','Angkatan');
                        $condition = array_diff($request->planned_checked, $default);
                        $heading = $headings->map->heading->toArray();


                        $periode_kuisioner = tb_periode_kuesioner::where('id_periode', $request->periode)->where('id_tahun_periode', $request->tahun_periode)->get(['id_periode_kuesioner'])->toArray();
                        // dd($periode_kuisioner);
                        $kuisperiod = tb_kuesioner::whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuisperiod)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereYear('tahun_wisuda', $request->tahun_wisuda)->whereIn('id_alumni', $all_jawaban)->get();
                        $prodi = tb_prodi::get();
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
                        $periode = tb_periode::get();
                        // $angkatan = tb_angkatan::all();
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

                        if(is_null($request->row_nama)){
                            return redirect()->back()->with('error', 'Tidak ada data yang dicetak!');
                        }else{
                            $countnip = count($request->row_nama);
                            if($condition == []){
                                for ($nims = 0; $nims < $countnip; $nims++) {
                                    $dosenArray[] = array(
                                        "Nama Alumni"=>$request->row_ta[$nims],
                                        "NIK"=>$request->row_nik[$nims],
                                        "Nim Alumni"=>$request->row_nim[$nims],
                                        "Jenis Kelamin"=>$request->row_jk[$nims],
                                        "Alamat"=>$request->row_al[$nims],
                                        "No Hp"=>$request->row_nohp[$nims],
                                        "Email"=>$request->row_email[$nims],
                                        "Program Studi"=>$request->row_pro[$nims],
                                        "Angkatan"=>$request->row_ang[$nims],
                                        "Tahun Lulus"=>$request->row_tl[$nims],
                                        "Tahun Wisuda"=>$request->row_tw[$nims],
                                    );
                                }
                                    $alumniHead[] = (
                                        null
                                    );
                                }
                            }
                                //return Excel::download(new DosenExports($dosenArray,$dosenHead), 'Dosen.xlsx');
 
                        // $data['id_angkatan'] = $id_angkatan;
                        return response()->json($data, 200)->with(Excel::download(new AlumniExport($alumniarray,$alumniHead), 'Alumni.xlsx'));
                        // return redirect ('/admin/reportalumni');
                        
                    }else{
                        $periode_kuisioner = tb_periode_kuesioner::where('id_tahun_periode', $request->tahun_periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuisperiod = tb_kuesioner::whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuisperiod)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereYear('tahun_wisuda', $request->tahun_wisuda)->whereIn('id_alumni', $all_jawaban)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $periode = tb_periode::get();
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                }else{
                    if($request->periode != ""){
                        $periode_kuisioner = tb_periode_kuesioner::where('id_periode', $request->periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuisioner = tb_kuesioner::whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuisioner)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereYear('tahun_wisuda', $request->tahun_wisuda)->whereIn('id_alumni', $all_jawaban)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $periode = tb_periode::get();
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                    }else{
                        $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereYear('tahun_wisuda', $request->tahun_wisuda)->whereIn('id_alumni', $all_jawaban)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $periode = tb_periode::get();
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
            }else{
                if($request->tahun_periode != ""){
                    if($request->periode != ""){
                        $periode_kuisioner = tb_periode_kuesioner::where('id_periode', $request->periode)->where('id_tahun_periode', $request->tahun_periode)->get(['id_periode_kuesioner'])->toArray();
                        // dd($periode_kuisioner);
                        $kuisperiod = tb_kuesioner::whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuisperiod)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereIn('id_alumni', $all_jawaban)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $periode = tb_periode::get();
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                    }else{
                        $periode_kuisioner = tb_periode_kuesioner::where('id_tahun_periode', $request->tahun_periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuisperiod = tb_kuesioner::whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuisperiod)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereIn('id_alumni', $all_jawaban)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $periode = tb_periode::get();
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                }else{
                    if($request->periode != ""){
                        $periode_kuisioner = tb_periode_kuesioner::where('id_periode', $request->periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuisioner = tb_kuesioner::whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuisioner)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereIn('id_alumni', $all_jawaban)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $periode = tb_periode::get();
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                    }else{
                        $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereIn('id_alumni', $all_jawaban)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $periode = tb_periode::get();
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                        $periode_kuisioner = tb_periode_kuesioner::where('id_periode', $request->periode)->where('id_tahun_periode', $request->tahun_periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuisperiod = tb_kuesioner::whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuisperiod)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereYear('tahun_wisuda', $request->tahun_wisuda)->whereIn('id_alumni', $all_jawaban)->where('id_prodi', $request->prodi)->get();
                        $prodi = tb_prodi::get();
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
                        $id_prodi = $request->prodi;
                        // $angkatan = tb_angkatan::all();
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
                    }else{
                        $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereYear('tahun_wisuda', $request->tahun_wisuda)->whereIn('id_alumni', $all_jawaban)->where('id_prodi', $request->prodi)->get();
                        $prodi = tb_prodi::get();
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
                        $id_prodi = $request->prodi;
                        // $angkatan = tb_angkatan::all();
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
                }else{
                    if($request->periode != ""){
                        $periode_kuisioner = tb_periode_kuesioner::where('id_periode', $request->periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuisperiod = tb_kuesioner::whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuisperiod)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereYear('tahun_wisuda', $request->tahun_wisuda)->whereIn('id_alumni', $all_jawaban)->where('id_prodi', $request->prodi)->get();
                        $prodi = tb_prodi::get();
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
                        $id_prodi = $request->prodi;
                        // $angkatan = tb_angkatan::all();
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
                    }else{
                        $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereYear('tahun_wisuda', $request->tahun_wisuda)->whereIn('id_alumni', $all_jawaban)->where('id_prodi', $request->prodi)->get();
                        $prodi = tb_prodi::get();
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
                        $id_prodi = $request->prodi;
                        // $angkatan = tb_angkatan::all();
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
            }else{
                if($request->tahun_periode != ""){
                    if($request->periode != ""){
                        $periode_kuisioner = tb_periode_kuesioner::where('id_periode', $request->periode)->where('id_tahun_periode', $request->tahun_periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuisperiod = tb_kuesioner::whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuisperiod)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereIn('id_alumni', $all_jawaban)->where('id_prodi', $request->prodi)->get();
                        $prodi = tb_prodi::get();
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
                        $id_prodi = $request->prodi;
                        // $angkatan = tb_angkatan::all();
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
                    }else{
                        $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereIn('id_alumni', $all_jawaban)->where('id_prodi', $request->prodi)->get();
                        $prodi = tb_prodi::get();
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
                        $id_prodi = $request->prodi;
                        // $angkatan = tb_angkatan::all();
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
                }else{
                    if($request->periode != ""){
                        $periode_kuisioner = tb_periode_kuesioner::where('id_periode', $request->periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuisperiod = tb_kuesioner::whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuisperiod)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereIn('id_alumni', $all_jawaban)->where('id_prodi', $request->prodi)->get();
                        $prodi = tb_prodi::get();
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
                        $id_prodi = $request->prodi;
                        // $angkatan = tb_angkatan::all();
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
                    }else{
                        $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereIn('id_alumni', $all_jawaban)->where('id_prodi', $request->prodi)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $id_prodi = $request->prodi;
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                        $periode_kuisioner = tb_periode_kuesioner::where('id_periode', $request->periode)->where('id_tahun_periode', $request->tahun_periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuisperiod = tb_kuesioner::whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuisperiod)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereYear('tahun_wisuda', $request->tahun_wisuda)->whereIn('id_alumni', $all_jawaban)->where('id_angkatan', $request->angkatan)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                    }else{
                        $periode_kuisioner = tb_periode_kuesioner::where('id_tahun_periode', $request->tahun_periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuisperiod = tb_kuesioner::whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuisperiod)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereYear('tahun_wisuda', $request->tahun_wisuda)->whereIn('id_alumni', $all_jawaban)->where('id_angkatan', $request->angkatan)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                }else{
                    if($request->periode != ""){
                        $periode_kuisioner = tb_periode_kuesioner::where('id_periode', $request->periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuisperiod = tb_kuesioner::whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuisperiod)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereYear('tahun_wisuda', $request->tahun_wisuda)->whereIn('id_alumni', $all_jawaban)->where('id_angkatan', $request->angkatan)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                    }else{
                        $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereYear('tahun_wisuda', $request->tahun_wisuda)->whereIn('id_alumni', $all_jawaban)->where('id_angkatan', $request->angkatan)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
            }else{
                if($request->tahun_periode != ""){
                    if($request->periode != ""){
                        $periode_kuisioner = tb_periode_kuesioner::where('id_periode', $request->periode)->where('id_tahun_periode', $request->tahun_periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuisperiod = tb_kuesioner::whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuisperiod)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereIn('id_alumni', $all_jawaban)->where('id_angkatan', $request->angkatan)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                    }else{
                        $periode_kuisioner = tb_periode_kuesioner::where('id_tahun_periode', $request->tahun_periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuisperiod = tb_kuesioner::whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuisperiod)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereIn('id_alumni', $all_jawaban)->where('id_angkatan', $request->angkatan)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                }else{
                    if($request->periode != ""){
                        $periode_kuisioner = tb_periode_kuesioner::where('id_periode', $request->periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuisperiod = tb_kuesioner::whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuisperiod)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereIn('id_alumni', $all_jawaban)->where('id_angkatan', $request->angkatan)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                    }else{
                        $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereIn('id_alumni', $all_jawaban)->where('id_angkatan', $request->angkatan)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                        $periode_kuisioner = tb_periode_kuesioner::where('id_periode', $request->periode)->where('id_tahun_periode', $request->tahun_periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuesioner = tb_kuesioner::where('id_bank_soal', $request->kategori_1)->whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuesioner)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereYear('tahun_wisuda', $request->tahun_wisuda)->whereIn('id_alumni', $all_jawaban)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $periode = tb_periode::get();
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                    }else{
                        $periode_kuisioner = tb_periode_kuesioner::where('id_tahun_periode', $request->tahun_periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuesioner = tb_kuesioner::where('id_bank_soal', $request->kategori_1)->whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuesioner)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereYear('tahun_wisuda', $request->tahun_wisuda)->whereIn('id_alumni', $all_jawaban)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $periode = tb_periode::get();
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                }else{
                    if($request->periode != ""){
                        $periode_kuisioner = tb_periode_kuesioner::where('id_periode', $request->periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuesioner = tb_kuesioner::where('id_bank_soal', $request->kategori_1)->whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuesioner)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereYear('tahun_wisuda', $request->tahun_wisuda)->whereIn('id_alumni', $all_jawaban)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $periode = tb_periode::get();
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                    }else{
                        $kuesioner = tb_kuesioner::where('id_bank_soal', $request->kategori_1)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuesioner)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereYear('tahun_wisuda', $request->tahun_wisuda)->whereIn('id_alumni', $all_jawaban)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $periode = tb_periode::get();
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
            }else{
                if($request->tahun_periode != ""){
                    if($request->periode != ""){
                        $periode_kuisioner = tb_periode_kuesioner::where('id_periode', $request->periode)->where('id_tahun_periode', $request->tahun_periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuesioner = tb_kuesioner::where('id_bank_soal', $request->kategori_1)->whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuesioner)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereIn('id_alumni', $all_jawaban)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $periode = tb_periode::get();
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                    }else{
                        $periode_kuisioner = tb_periode_kuesioner::where('id_tahun_periode', $request->tahun_periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuesioner = tb_kuesioner::where('id_bank_soal', $request->kategori_1)->whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuesioner)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereIn('id_alumni', $all_jawaban)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $periode = tb_periode::get();
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                }else{
                    if($request->periode != ""){
                        $periode_kuisioner = tb_periode_kuesioner::where('id_periode', $request->periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuesioner = tb_kuesioner::where('id_bank_soal', $request->kategori_1)->whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuesioner)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereIn('id_alumni', $all_jawaban)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $periode = tb_periode::get();
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                    }else{
                        $kuesioner = tb_kuesioner::where('id_bank_soal', $request->kategori_1)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuesioner)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereIn('id_alumni', $all_jawaban)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $periode = tb_periode::get();
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                        $periode_kuisioner = tb_periode_kuesioner::where('id_periode', $request->periode)->where('id_tahun_periode', $request->tahun_periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuisperiod = tb_kuesioner::whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuisperiod)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereYear('tahun_wisuda', $request->tahun_wisuda)->whereIn('id_alumni', $all_jawaban)->where('id_prodi', $request->prodi)->where('id_angkatan', $request->angkatan)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $id_prodi = $request->prodi;
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                    }else{
                        $periode_kuisioner = tb_periode_kuesioner::where('id_tahun_periode', $request->tahun_periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuisperiod = tb_kuesioner::whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuisperiod)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereYear('tahun_wisuda', $request->tahun_wisuda)->whereIn('id_alumni', $all_jawaban)->where('id_prodi', $request->prodi)->where('id_angkatan', $request->angkatan)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $id_prodi = $request->prodi;
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                }else{
                    if($request->periode != ""){
                        $periode_kuisioner = tb_periode_kuesioner::where('id_periode', $request->periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuisperiod = tb_kuesioner::whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuisperiod)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereYear('tahun_wisuda', $request->tahun_wisuda)->whereIn('id_alumni', $all_jawaban)->where('id_prodi', $request->prodi)->where('id_angkatan', $request->angkatan)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $id_prodi = $request->prodi;
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                    }else{
                        $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereYear('tahun_wisuda', $request->tahun_wisuda)->whereIn('id_alumni', $all_jawaban)->where('id_prodi', $request->prodi)->where('id_angkatan', $request->angkatan)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $id_prodi = $request->prodi;
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
            }else{
                if($request->tahun_periode != ""){
                    if($request->periode != ""){
                        $periode_kuisioner = tb_periode_kuesioner::where('id_periode', $request->periode)->where('id_tahun_periode', $request->tahun_periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuisperiod = tb_kuesioner::whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuisperiod)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereIn('id_alumni', $all_jawaban)->where('id_prodi', $request->prodi)->where('id_angkatan', $request->angkatan)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $id_prodi = $request->prodi;
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                    }else{
                        $periode_kuisioner = tb_periode_kuesioner::where('id_tahun_periode', $request->tahun_periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuisperiod = tb_kuesioner::whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuisperiod)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereIn('id_alumni', $all_jawaban)->where('id_prodi', $request->prodi)->where('id_angkatan', $request->angkatan)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $id_prodi = $request->prodi;
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                }else{
                    if($request->periode != ""){
                        $periode_kuisioner = tb_periode_kuesioner::where('id_periode', $request->periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuisperiod = tb_kuesioner::whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuisperiod)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereIn('id_alumni', $all_jawaban)->where('id_prodi', $request->prodi)->where('id_angkatan', $request->angkatan)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $id_prodi = $request->prodi;
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                    }else{
                        $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereIn('id_alumni', $all_jawaban)->where('id_prodi', $request->prodi)->where('id_angkatan', $request->angkatan)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $id_prodi = $request->prodi;
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                        $periode_kuisioner = tb_periode_kuesioner::where('id_periode', $request->periode)->where('id_tahun_periode', $request->tahun_periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuesioner = tb_kuesioner::where('id_bank_soal', $request->kategori_1)->whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuesioner)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        // $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereYear('tahun_wisuda', $request->tahun_wisuda)->whereIn('id_alumni', $all_jawaban)->where('id_prodi', $request->prodi)->get();
                        $prodi = tb_prodi::get();
                        $angkatan = tb_angkatan::get();
                        // $id_angkatan = $request->angkatan;
                        $id_prodi = $request->prodi;
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                    }else{
                        $periode_kuisioner = tb_periode_kuesioner::where('id_tahun_periode', $request->tahun_periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuesioner = tb_kuesioner::where('id_bank_soal', $request->kategori_1)->whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuesioner)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        // $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereYear('tahun_wisuda', $request->tahun_wisuda)->whereIn('id_alumni', $all_jawaban)->where('id_prodi', $request->prodi)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $id_prodi = $request->prodi;
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                }else{
                    if($request->periode != ""){
                        $periode_kuisioner = tb_periode_kuesioner::where('id_periode', $request->periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuesioner = tb_kuesioner::where('id_bank_soal', $request->kategori_1)->whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuesioner)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        // $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereYear('tahun_wisuda', $request->tahun_wisuda)->whereIn('id_alumni', $all_jawaban)->where('id_prodi', $request->prodi)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $id_prodi = $request->prodi;
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                    }else{
                        $kuesioner = tb_kuesioner::where('id_bank_soal', $request->kategori_1)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuesioner)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        // $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereYear('tahun_wisuda', $request->tahun_wisuda)->whereIn('id_alumni', $all_jawaban)->where('id_prodi', $request->prodi)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $id_prodi = $request->prodi;
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
            }else{
                if($request->tahun_periode != ""){
                    if($request->periode != ""){
                        $periode_kuisioner = tb_periode_kuesioner::where('id_periode', $request->periode)->where('id_tahun_periode', $request->tahun_periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuesioner = tb_kuesioner::where('id_bank_soal', $request->kategori_1)->whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuesioner)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        // $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereIn('id_alumni', $all_jawaban)->where('id_prodi', $request->prodi)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $id_prodi = $request->prodi;
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                    }else{
                        $periode_kuisioner = tb_periode_kuesioner::where('id_tahun_periode', $request->tahun_periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuesioner = tb_kuesioner::where('id_bank_soal', $request->kategori_1)->whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuesioner)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        // $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereIn('id_alumni', $all_jawaban)->where('id_prodi', $request->prodi)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $id_prodi = $request->prodi;
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                }else{
                    if($request->periode != ""){
                        $periode_kuisioner = tb_periode_kuesioner::where('id_periode', $request->periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuesioner = tb_kuesioner::where('id_bank_soal', $request->kategori_1)->whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuesioner)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        // $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereIn('id_alumni', $all_jawaban)->where('id_prodi', $request->prodi)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $id_prodi = $request->prodi;
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                    }else{
                        $kuesioner = tb_kuesioner::where('id_bank_soal', $request->kategori_1)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuesioner)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        // $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereIn('id_alumni', $all_jawaban)->where('id_prodi', $request->prodi)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $id_prodi = $request->prodi;
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                        $periode_kuisioner = tb_periode_kuesioner::where('id_periode', $request->periode)->where('id_tahun_periode', $request->tahun_periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuesioner = tb_kuesioner::where('id_bank_soal', $request->kategori_1)->whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuesioner)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereYear('tahun_wisuda', $request->tahun_wisuda)->whereIn('id_alumni', $all_jawaban)->where('id_angkatan', $request->angkatan)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                    }else{
                        $periode_kuisioner = tb_periode_kuesioner::where('id_tahun_periode', $request->tahun_periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuesioner = tb_kuesioner::where('id_bank_soal', $request->kategori_1)->whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuesioner)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereYear('tahun_wisuda', $request->tahun_wisuda)->whereIn('id_alumni', $all_jawaban)->where('id_angkatan', $request->angkatan)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                }else{
                    if($request->periode != ""){
                        $periode_kuisioner = tb_periode_kuesioner::where('id_periode', $request->periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuesioner = tb_kuesioner::where('id_bank_soal', $request->kategori_1)->whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuesioner)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereYear('tahun_wisuda', $request->tahun_wisuda)->whereIn('id_alumni', $all_jawaban)->where('id_angkatan', $request->angkatan)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                    }else{
                        $kuesioner = tb_kuesioner::where('id_bank_soal', $request->kategori_1)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuesioner)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereYear('tahun_wisuda', $request->tahun_wisuda)->whereIn('id_alumni', $all_jawaban)->where('id_angkatan', $request->angkatan)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
            }else{
                if($request->tahun_periode != ""){
                    if($request->periode != ""){
                        $periode_kuisioner = tb_periode_kuesioner::where('id_periode', $request->periode)->where('id_tahun_periode', $request->tahun_periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuesioner = tb_kuesioner::where('id_bank_soal', $request->kategori_1)->whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuesioner)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereIn('id_alumni', $all_jawaban)->where('id_angkatan', $request->angkatan)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                    }else{
                        $periode_kuisioner = tb_periode_kuesioner::where('id_tahun_periode', $request->tahun_periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuesioner = tb_kuesioner::where('id_bank_soal', $request->kategori_1)->whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuesioner)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereIn('id_alumni', $all_jawaban)->where('id_angkatan', $request->angkatan)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                }else{
                    if($request->periode != ""){
                        $periode_kuisioner = tb_periode_kuesioner::where('id_periode', $request->periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuesioner = tb_kuesioner::where('id_bank_soal', $request->kategori_1)->whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuesioner)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereIn('id_alumni', $all_jawaban)->where('id_angkatan', $request->angkatan)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                    }else{
                        $kuesioner = tb_kuesioner::where('id_bank_soal', $request->kategori_1)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuesioner)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereIn('id_alumni', $all_jawaban)->where('id_angkatan', $request->angkatan)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                        $periode_kuisioner = tb_periode_kuesioner::where('id_periode', $request->periode)->where('id_tahun_periode', $request->tahun_periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuesioner = tb_kuesioner::where('id_bank_soal', $request->kategori_1)->whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuesioner)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        // $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereYear('tahun_wisuda', $request->tahun_wisuda)->whereIn('id_alumni', $all_jawaban)->where('id_angkatan', $request->angkatan)->where('id_prodi', $request->prodi)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                    }else{
                        $periode_kuisioner = tb_periode_kuesioner::where('id_tahun_periode', $request->tahun_periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuesioner = tb_kuesioner::where('id_bank_soal', $request->kategori_1)->whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuesioner)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        // $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereYear('tahun_wisuda', $request->tahun_wisuda)->whereIn('id_alumni', $all_jawaban)->where('id_angkatan', $request->angkatan)->where('id_prodi', $request->prodi)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                }else{
                    if($request->periode != ""){
                        $periode_kuisioner = tb_periode_kuesioner::where('id_periode', $request->periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuesioner = tb_kuesioner::where('id_bank_soal', $request->kategori_1)->whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuesioner)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        // $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereYear('tahun_wisuda', $request->tahun_wisuda)->whereIn('id_alumni', $all_jawaban)->where('id_angkatan', $request->angkatan)->where('id_prodi', $request->prodi)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                    }else{
                        $kuesioner = tb_kuesioner::where('id_bank_soal', $request->kategori_1)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuesioner)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        // $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereYear('tahun_wisuda', $request->tahun_wisuda)->whereIn('id_alumni', $all_jawaban)->where('id_angkatan', $request->angkatan)->where('id_prodi', $request->prodi)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
            }else{
                if($request->tahun_periode != ""){
                    if($request->periode != ""){
                        $periode_kuisioner = tb_periode_kuesioner::where('id_periode', $request->periode)->where('id_tahun_periode', $request->tahun_periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuesioner = tb_kuesioner::where('id_bank_soal', $request->kategori_1)->whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuesioner)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        // $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereIn('id_alumni', $all_jawaban)->where('id_angkatan', $request->angkatan)->where('id_prodi', $request->prodi)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                    }else{
                        $periode_kuisioner = tb_periode_kuesioner::where('id_tahun_periode', $request->tahun_periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuesioner = tb_kuesioner::where('id_bank_soal', $request->kategori_1)->whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuesioner)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        // $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereIn('id_alumni', $all_jawaban)->where('id_angkatan', $request->angkatan)->where('id_prodi', $request->prodi)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                }else{
                    if($request->periode != ""){
                        $periode_kuisioner = tb_periode_kuesioner::where('id_periode', $request->periode)->get(['id_periode_kuesioner'])->toArray();
                        $kuesioner = tb_kuesioner::where('id_bank_soal', $request->kategori_1)->whereIn('id_periode', $periode_kuisioner)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuesioner)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        // $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereIn('id_alumni', $all_jawaban)->where('id_angkatan', $request->angkatan)->where('id_prodi', $request->prodi)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
                    }else{
                        $kuesioner = tb_kuesioner::where('id_bank_soal', $request->kategori_1)->get(['id_kuesioner'])->toArray();
                        $detailkues = tb_detail_kuesioner::whereIn('id_kuesioner', $kuesioner)->get(['id_detail_kuesioner'])->toArray();
                        $all_jawaban = tb_jawaban::whereIn('id_detail_kuesioner', $detailkues)->get(['id_alumni'])->toArray();
                        // $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
                        $tracers = tb_alumni::with('relasiAlumnitoProdi')->with('relasiAlumnitoAngkatan')->whereIn('id_alumni', $all_jawaban)->where('id_angkatan', $request->angkatan)->where('id_prodi', $request->prodi)->get();
                        $prodi = tb_prodi::get();
                        // $angkatan = tb_angkatan::get();
                        $id_angkatan = $request->angkatan;
                        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
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
        $angkatan = tb_angkatan::orderBy('tahun_angkatan', 'ASC')->get();
        return view ('/report/reportalumni', compact('tracers', 'prodi', 'angkatan'));
    }
}