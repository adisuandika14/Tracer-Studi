<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\tb_detail_kuesioner;
use App\tb_opsi;
use App\tb_kuesioner;
use App\tb_jenis_kuesioner;
use App\tb_master_kuesioner;
use App\tb_jawaban;
use App\tb_prodi;
use App\tb_angkatan;
use App\tb_alumni;
use App\tb_periode;

class detailkuesionerController extends Controller
{
    // public function show(){
    //     $detail = tb_detail_kuesioner::all();
    //     $kuesioner = tb_kuesioner::all();
    //     $jenis = tb_jenis_kuesioner::all();
    //     $opsi = tb_opsi::all();
    //         return view('/kuesioner/showkuesioner', compact ('detail','kuesioner','opsi','jenis'));
    //     }

    public function detail($id)
    {
        $id_periode = tb_periode::max('id_periode');
        $judul_kuesioner = tb_kuesioner::find($id)->type_kuesioner;
        $periodes = tb_periode::get();
        $kuesioner = tb_jenis_kuesioner::get();
        $opsi =tb_opsi::get();
        
        $detail = tb_detail_kuesioner::where('id_kuesioner', $id)->where('id_periode', $id_periode)->get();
        $id_kuesioner = $id;
        //dd($detail);
        return view('/kuesioner/showkuesioner', compact('detail','kuesioner','opsi', 'id_kuesioner', 'judul_kuesioner', 'periodes', 'id_periode'));
    }

    public function filter(Request $request)
    {
        $detail = tb_detail_kuesioner::where('id_kuesioner', $request->id_kuesioner)->where('id_periode', $request->id_periode)->get();
        $opsi =tb_opsi::get();
        $hasil = view('kuesioner.filter', ['detail' => $detail, 'opsi' => $opsi])->render();
        // $hasil = $kategori;
        return response()->json(['success' => 'Produk difilter', 'hasil' => $hasil]);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'id_jenis' => 'required', 
            'pertanyaan' => 'required',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator);
        }

        $detail_kuesioner = new tb_detail_kuesioner();

        if($request->id_jenis ==  2){
            $detail_kuesioner->id_kuesioner = $request->id_kuesioner;
            $detail_kuesioner->id_periode = $request->id_periode;
            $detail_kuesioner->id_jenis = 2;
            $detail_kuesioner->pertanyaan = $request->pertanyaan;
            $detail_kuesioner->status = "Menunggu Konfirmasi";
            $detail_kuesioner->save();
        }

        if($request->id_jenis == 1 || $request->id_jenis == 3){
            $detail_kuesioner->id_periode = $request->id_periode;
            $detail_kuesioner->id_kuesioner = $request->id_kuesioner;
            $detail_kuesioner->id_jenis = $request->id_jenis;
            $detail_kuesioner->pertanyaan = $request->pertanyaan;
            $detail_kuesioner->status = "Menunggu Konfirmasi";
            $detail_kuesioner->save();

            $detail_kuesioner = tb_detail_kuesioner::find(tb_detail_kuesioner::max('id_detail_kuesioner'));
            if($request->opsi1 != ""){
                $opsi = new tb_opsi();
                $opsi->opsi = $request->opsi1;
                $opsi->id_detail_kuesioner = $detail_kuesioner->id_detail_kuesioner;
                $opsi->save();
            }

            if($request->opsi2 != ""){
                $opsi = new tb_opsi();
                $opsi->opsi = $request->opsi2;
                $opsi->id_detail_kuesioner = $detail_kuesioner->id_detail_kuesioner;
                $opsi->save();
            }

            if($request->opsi3 != ""){
                $opsi = new tb_opsi();
                $opsi->opsi = $request->opsi3;
                $opsi->id_detail_kuesioner = $detail_kuesioner->id_detail_kuesioner;
                $opsi->save();
            }

            if($request->opsi4 != ""){
                $opsi = new tb_opsi();
                $opsi->opsi = $request->opsi4;
                $opsi->id_detail_kuesioner = $detail_kuesioner->id_detail_kuesioner;
                $opsi->save();
            }

            if($request->opsi5 != ""){
                $opsi = new tb_opsi();
                $opsi->opsi = $request->opsi5;
                $opsi->id_detail_kuesioner = $detail_kuesioner->id_detail_kuesioner;
                $opsi->save();
            }
            if($request->opsi6 != ""){
                $opsi = new tb_opsi();
                $opsi->opsi = $request->opsi6;
                $opsi->id_detail_kuesioner = $detail_kuesioner->id_detail_kuesioner;
                $opsi->save();
            }
            if($request->opsi7 != ""){
                $opsi = new tb_opsi();
                $opsi->opsi = $request->opsi7;
                $opsi->id_detail_kuesioner = $detail_kuesioner->id_detail_kuesioner;
                $opsi->save();
            }
            if($request->opsi8 != ""){
                $opsi = new tb_opsi();
                $opsi->opsi = $request->opsi8;
                $opsi->id_detail_kuesioner = $detail_kuesioner->id_detail_kuesioner;
                $opsi->save();
            }
            if($request->opsi9 != ""){
                $opsi = new tb_opsi();
                $opsi->opsi = $request->opsi9;
                $opsi->id_detail_kuesioner = $detail_kuesioner->id_detail_kuesioner;
                $opsi->save();
            }
            if($request->opsi10 != ""){
                $opsi = new tb_opsi();
                $opsi->opsi = $request->opsi10;
                $opsi->id_detail_kuesioner = $detail_kuesioner->id_detail_kuesioner;
                $opsi->save();
            }
        }

        return redirect()->route('show-kuesioner', $request->id_kuesioner)->with('statusInput', 'Pertanyaan berhasil ditambahkan');
    }

    public function delete($id)
    {
        $detail_kuesioner = tb_detail_kuesioner::find($id);
        $detail_kuesioner->delete();

        $opsis = tb_opsi::get();
        foreach($opsis as $opsi){
            if($opsi->id_detail_kuesioner == $id){
                $opsi->delete();
            }
        }
        return back()->with('statusInput', 'Pertanyaan berhasil dihapus');
    }

    public function edit($id)
    {
        $detail_kuesioner = tb_detail_kuesioner::find($id);
        $opsis = tb_opsi::where('id_detail_kuesioner', $detail_kuesioner->id_detail_kuesioner)->get();
        return response()->json(['success' => 'Berhasil', 'detail_kuesioner' => $detail_kuesioner, 'opsis' => $opsis]);
    }

    public function update($id, Request $request){
        $validator = Validator::make($request->all(), [
            'edit_id_jenis' => 'required',
            'edit_pertanyaan' => 'required',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator);
        }

        

        $detail_kuesioner = tb_detail_kuesioner::find($id);

        $opsis = tb_opsi::get();
        foreach($opsis as $opsi){
            if($opsi->id_detail_kuesioner == $id){
                $opsi->delete();
            }
        }

        if($request->edit_id_jenis ==  2){
            $detail_kuesioner->id_periode = $request->id_periode;
            $detail_kuesioner->id_kuesioner = $request->id_kuesioner;
            $detail_kuesioner->id_jenis = 2;
            $detail_kuesioner->pertanyaan = $request->edit_pertanyaan;
            $detail_kuesioner->status = "Menunggu Konfirmasi";
            $detail_kuesioner->update();
        }

        if($request->edit_id_jenis == 1 || $request->edit_id_jenis == 3){
            $detail_kuesioner->id_periode = $request->id_periode;
            $detail_kuesioner->id_kuesioner = $request->id_kuesioner;
            $detail_kuesioner->id_jenis = 1;
            $detail_kuesioner->pertanyaan = $request->edit_pertanyaan;
            $detail_kuesioner->status = "Menunggu Konfirmasi";
            $detail_kuesioner->update();

            if($request->edit_opsi1 != ""){
                $opsi = new tb_opsi();
                $opsi->opsi = $request->edit_opsi1;
                $opsi->id_detail_kuesioner = $detail_kuesioner->id_detail_kuesioner;
                $opsi->save();
            }

            if($request->edit_opsi2 != ""){
                $opsi = new tb_opsi();
                $opsi->opsi = $request->edit_opsi2;
                $opsi->id_detail_kuesioner = $detail_kuesioner->id_detail_kuesioner;
                $opsi->save();
            }

            if($request->edit_opsi3 != ""){
                $opsi = new tb_opsi();
                $opsi->opsi = $request->edit_opsi3;
                $opsi->id_detail_kuesioner = $detail_kuesioner->id_detail_kuesioner;
                $opsi->save();
            }

            if($request->edit_opsi4 != ""){
                $opsi = new tb_opsi();
                $opsi->opsi = $request->edit_opsi4;
                $opsi->id_detail_kuesioner = $detail_kuesioner->id_detail_kuesioner;
                $opsi->save();
            }

            if($request->edit_opsi5 != ""){
                $opsi = new tb_opsi();
                $opsi->opsi = $request->edit_opsi5;
                $opsi->id_detail_kuesioner = $detail_kuesioner->id_detail_kuesioner;
                $opsi->save();
            }
            if($request->edit_opsi6 != ""){
                $opsi = new tb_opsi();
                $opsi->opsi = $request->edit_opsi6;
                $opsi->id_detail_kuesioner = $detail_kuesioner->id_detail_kuesioner;
                $opsi->save();
            }
            if($request->edit_opsi7 != ""){
                $opsi = new tb_opsi();
                $opsi->opsi = $request->edit_opsi7;
                $opsi->id_detail_kuesioner = $detail_kuesioner->id_detail_kuesioner;
                $opsi->save();
            }
            if($request->edit_opsi8 != ""){
                $opsi = new tb_opsi();
                $opsi->opsi = $request->edit_opsi8;
                $opsi->id_detail_kuesioner = $detail_kuesioner->id_detail_kuesioner;
                $opsi->save();
            }
            if($request->edit_opsi9 != ""){
                $opsi = new tb_opsi();
                $opsi->opsi = $request->edit_opsi9;
                $opsi->id_detail_kuesioner = $detail_kuesioner->id_detail_kuesioner;
                $opsi->save();
            }
            if($request->edit_opsi10 != ""){
                $opsi = new tb_opsi();
                $opsi->opsi = $request->edit_opsi10;
                $opsi->id_detail_kuesioner = $detail_kuesioner->id_detail_kuesioner;
                $opsi->save();
            }
        }

        return redirect()->route('show-kuesioner', $request->id_kuesioner)->with('statusInput', 'Pertanyaan berhasil diperbaharui');
    }


    public function tracer(){
        $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
        $tracers = tb_alumni::with('relasiAlumnitoProdi')->whereIn('id_alumni', $all_jawaban)->get();
        $prodi = tb_prodi::get();
        $angkatan = tb_angkatan::get();
        $periode = tb_periode::get();
        

        //dd($detailjawaban);
        return view ('/kuesioner/tracer', compact('tracers', 'prodi', 'angkatan','periode'));
    }

    public function detailtracer($id){
        $alumni = tb_alumni::where('id_alumni', $id)->first();
        $jawaban = tb_jawaban::with('relasiJawabantoDetail')->where('id_alumni', $alumni->id_alumni)->get();

        //dd($detailjawaban);
        return view ('/kuesioner/detail-tracer', compact('alumni', 'jawaban'));
    }

    public function filtertracer(Request $request){
        if($request->prodi == "" && $request->angkatan == ""){
            return redirect ('/admin/tracer');
        }else if($request->prodi == "" && $request->angkatan != ""){
            $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
            $tracers = tb_alumni::with('relasiAlumnitoProdi')->whereIn('id_alumni', $all_jawaban)->where('id_angkatan', $request->angkatan)->get();
            $prodi = tb_prodi::get();
            $angkatan = tb_angkatan::get();
            $id_angkatan = $request->angkatan;
            return view ('/kuesioner/tracer', compact('tracers', 'prodi', 'angkatan', 'id_angkatan'));
        }else if($request->prodi != "" && $request->angkatan == ""){
            $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
            $tracers = tb_alumni::with('relasiAlumnitoProdi')->whereIn('id_alumni', $all_jawaban)->where('id_prodi', $request->prodi)->get();
            $prodi = tb_prodi::get();
            $angkatan = tb_angkatan::get();
            $id_prodi = $request->prodi;
            return view ('/kuesioner/tracer', compact('tracers', 'prodi', 'angkatan', 'id_prodi'));
        }else if($request->prodi != "" && $request->angkatan != ""){
            $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
            $tracers = tb_alumni::with('relasiAlumnitoProdi')->whereIn('id_alumni', $all_jawaban)->where('id_prodi', $request->prodi)->where('id_angkatan', $request->angkatan)->get();
            $prodi = tb_prodi::get();
            $angkatan = tb_angkatan::get();
            $id_angkatan = $request->angkatan;
            $id_prodi = $request->prodi;
            return view ('/kuesioner/tracer', compact('tracers', 'prodi', 'angkatan', 'id_prodi', 'id_angkatan'));
        }



        $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
        $tracers = tb_alumni::with('relasiAlumnitoProdi')->whereIn('id_alumni', $all_jawaban)->get();
        $prodi = tb_prodi::get();
        $angkatan = tb_angkatan::get();
        return view ('/kuesioner/tracer', compact('tracers', 'prodi', 'angkatan'));
    }
}
