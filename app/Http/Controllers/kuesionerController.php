<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\tb_jenis_kuesioner;
use App\tb_kuesioner;
use App\tb_prodi;
use App\tb_master_kuesioner;
use App\tb_alumni;
use App\tb_angkatan;
use App\tb_detail_kuesioner;
use App\tb_opsi;
use App\tb_jawaban;
use App\tb_periode_kuesioner;
use App\tb_tahun_periode;
use App\tb_periode;
use App\tb_soal_alumni;
use Illuminate\Support\Facades\DB;  

class kuesionerController extends Controller
{
    public function show($id){
        $periode = tb_periode_kuesioner::where('id_periode_kuesioner', $id)->first();
        $tahun_kuesioner = tb_tahun_periode::where('id_tahun_periode', $periode->id_tahun_periode)->first()->tahun_periode;
        $periode_kuesioner = tb_periode::where('id_periode', $periode->id_periode)->first()->periode;




        //$detail = tb_detail_kuesioner::with('relasiDetailtoKuesioner','relasiDetailtoAlumni')->get();
        $kuesioner = tb_kuesioner::where('id_periode', $id)->get();
        $tahun_periodes = tb_periode_kuesioner::with('relasiPeriodekuesionertoTahun', 'relasiPeriodekuesionertoPeriode')->get();
        $max_id_kuesioner = tb_kuesioner::max('id_kuesioner');
        $id_periode_kuesioner = $id;
        

            return view('/kuesioner/kuesioner', compact ('kuesioner','tahun_periodes','id_periode_kuesioner','tahun_kuesioner','periode_kuesioner'));
        }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'type_kuesioner' => 'required',
        ],[
             'type_kuesioner.required' => "Anda Belum Menambahkan Kuesioner",
         ]);

        if($validator->fails()){
            return back()->withErrors($validator);
        }

        $detail_kuesioner = new tb_kuesioner();
        $detail_kuesioner->id_periode = $request->id_periode;
        $detail_kuesioner->type_kuesioner = $request->type_kuesioner;
        $detail_kuesioner->status = "Menunggu Konfirmasi";
        $detail_kuesioner->save();

        return redirect ('/admin/kuesioner/'.$request->id_periode)->with('statusInput','Data berhasil ditambahkan!');
    }
    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'type_kuesioner' => 'required',
        ],[
             'type_kuesioner.required' => "Anda Belum Menambahkan Kuesioner",
         ]);

        if($validator->fails()){
            return back()->withErrors($validator);
        }
        $res = NULL;
        $updatedata = tb_kuesioner::find($request->id_kuesioner);
        $updatedata->id_periode = $request->id_periode;
        $updatedata->type_kuesioner = $request->type_kuesioner;
        $updatedata->status = "Menunggu Konfirmasi";
        $updatedata->update();
        //dd($updatedata);
       return redirect('/admin/kuesioner/'.$request->id_periode)->with('statusInput','Data berhasil diperbaharui!');
    }

    public function delete($id){
        $delete = tb_kuesioner::find($id);
        $delete->delete();
        return redirect()->back()->with('statusInput','Data berhasil dihapus!'); 
    }

    public function detail($id)
    {
        $judul_kuesioner = tb_kuesioner::find($id)->type_kuesioner;
        $kuesioner = tb_jenis_kuesioner::all();
        $opsi =tb_opsi::all();

        $detail = tb_detail_kuesioner::where('id_kuesioner', $id)->get();
        $id_kuesioner = $id;
    
        return view('/kuesioner/showkuesioner', compact('detail','kuesioner','opsi', 'id_kuesioner', 'judul_kuesioner'));
    }
    




    public function showtracer(){
        $tracer = tb_jawaban::with('relasiJawabantoAlumni','relasijawabantoDetail')->get();

        $id = tb_alumni::get();
        $detail = tb_jawaban::where('id_jawaban', $id)->get();
        $id_jawaban = $id;
        
        return view('/kuesioner/tracer',compact('detail'));
    }

    public function filter(Request $request)
    {
        $kuesioner = tb_kuesioner::where('id_periode', $request->id_periode)->get();
        $hasil = view('kuesioner.filter_kuesioner', ['kuesioner' => $kuesioner])->render();
        // $hasil = $kategori;
        return response()->json(['success' => 'Produk difilter', 'hasil' => $hasil]);
    }

    public function bank_soal_data($id_periode){
        $kuesioner = tb_kuesioner::where('id_periode', $id_periode)->pluck('id_bank_soal')->toArray();
        $bank_soal_kuesioner = tb_soal_alumni::whereNotIn('id_soal_alumni', array_filter($kuesioner))->get();
        return response()->json($bank_soal_kuesioner);
    }

    public function create_from_bank_soal($id_periode, Request $request){
        $all_bank_soal = tb_soal_alumni::get();
        foreach($all_bank_soal as $bank_soal){
            if($request->{'bank_soal_' .$bank_soal->id_soal_alumni}  != ""){
                $detail_kuesioner = new tb_kuesioner();
                $detail_kuesioner->id_periode = $id_periode;
                $detail_kuesioner->type_kuesioner = $bank_soal->pertanyaan;
                $detail_kuesioner->status = "Menunggu Konfirmasi";
                $detail_kuesioner->id_bank_soal = $bank_soal->id_soal_alumni;
                $detail_kuesioner->save();
            }
            
        }
        return redirect('/admin/kuesioner')->with('statusInput','Data berhasil disimpan!');
    }

}
