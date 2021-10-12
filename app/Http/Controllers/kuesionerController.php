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

use Illuminate\Support\Facades\DB;  

class kuesionerController extends Controller
{
    public function show(){
        $max_id_kuesioner = tb_kuesioner::max('id_kuesioner');
        $id_periode_kuesioner = tb_kuesioner::where('id_kuesioner', $max_id_kuesioner)->first(['id_periode'])->id_periode;
        $detail = tb_detail_kuesioner::with('relasiDetailtoKuesioner','relasiDetailtoAlumni')->get();
        $prodi = tb_prodi::all();
        $kuesioner = tb_kuesioner::where('id_periode', $id_periode_kuesioner)->get();
        $alumni = tb_alumni::all();
        $tahun_periodes = tb_periode_kuesioner::with('relasiPeriodekuesionertoTahun', 'relasiPeriodekuesionertoPeriode')->get();
        $opsi = tb_opsi::all();
            return view('/kuesioner/kuesioner', compact ('alumni','detail','prodi','kuesioner','opsi','tahun_periodes','id_periode_kuesioner'));
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
        $detail_kuesioner->id_periode = $request->create_id_periode;
        $detail_kuesioner->type_kuesioner = $request->type_kuesioner;
        $detail_kuesioner->status = "Menunggu Konfirmasi";
        $detail_kuesioner->save();

        return redirect('/admin/kuesioner')->with('statusInput','Data berhasil disimpan!');
    }

    public function delete($id){
        $delete = tb_kuesioner::find($id);
        $delete->delete();
        return redirect ('/admin/kuesioner')->with('statusInput','Data berhasil dihapus!'); 
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
    

    public function update(Request $request){
        $res = NULL;
        $updatedata = tb_kuesioner::find($request->id_kuesioner);
        $updatedata->type_kuesioner = $request->type_kuesioner;

        $updatedata->update();
        //dd($updatedata);
       return redirect('/admin/kuesioner')->with('statusInput','Data berhasil diupdate!');
    }


    public function showtracer(){
        //$tracer = tb_jawaban::with('relasiJawabantoAlumni','relasijawabantoDetailkuesioner')->get();

        // $alumni = tb_alumni::all();
        // $angkatan = tb_angkatan::all();
        // $prodi = tb_prodi::all();
        // $detail = tb_jawaban::all();

        
        // $detail = tb_jawaban::where('id_jawaban', $id)->get();

        // $id_jawaban = $id;

        // $tracer->relasiJawabantoAlumni()->nama_alumni;
        // $tracer->relasijawabantoDetailkuesioner->pertanyaan;
        // $tracer->relasijawabantoDetailkuesioner->relasiDetailtoKuesioner->type_kuesioner;
        $detail = DB::select('SELECT
        `tb_jawaban`.`jawaban`
        , `tb_alumni`.`nama_alumni`
        , `tb_alumni`.`id_angkatan`
        , `tb_alumni`.`id_prodi`
        , `tb_alumni`.`tahun_lulus`
        , `tb_angkatan`.`tahun_angkatan`
        , `tb_prodi`.`nama_prodi`
        , `tb_detail_kuesioner`.`pertanyaan`
    FROM
        `db_tracer_study`.`tb_alumni`
        INNER JOIN `db_tracer_study`.`tb_angkatan` 
            ON (`tb_alumni`.`id_angkatan` = `tb_angkatan`.`id_angkatan`)
        INNER JOIN `db_tracer_study`.`tb_prodi` 
            ON (`tb_alumni`.`id_prodi` = `tb_prodi`.`id_prodi`)
        INNER JOIN `db_tracer_study`.`tb_jawaban` 
            ON (`tb_jawaban`.`id_alumni` = `tb_alumni`.`id_alumni`)
        INNER JOIN `db_tracer_study`.`tb_detail_kuesioner` 
            ON (`tb_jawaban`.`id_detail_kuesioner` = `tb_detail_kuesioner`.`id_detail_kuesioner`);');


        return view('/kuesioner/tracer',compact('detail'));
    }

    public function filter(Request $request)
    {
        $kuesioner = tb_kuesioner::where('id_periode', $request->id_periode)->get();
        $hasil = view('kuesioner.filter_kuesioner', ['kuesioner' => $kuesioner])->render();
        // $hasil = $kategori;
        return response()->json(['success' => 'Produk difilter', 'hasil' => $hasil]);
    }

}
