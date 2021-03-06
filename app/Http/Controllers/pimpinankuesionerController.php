<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tb_jenis_kuesioner;
use App\tb_kuesioner;
use App\tb_prodi;
use App\tb_master_kuesioner;
use App\tb_alumni;
use App\tb_detail_kuesioner;
use App\tb_opsi;
use App\tb_jawaban;
use App\tb_angkatan;
use App\tb_periode;
use App\tb_periode_kuesioner;
use App\tb_tahun_periode;
use Illuminate\Support\Facades\DB; 

class pimpinankuesionerController extends Controller
{
    
    public function show(){
        $periode = tb_periode_kuesioner::get();
        $tahun = tb_tahun_periode::get();
        $periodekuesioner = tb_periode::get();


        return view('pimpinan/kuesioner/periodekuesioner', compact('periode','tahun','periodekuesioner'));
    }

    public function showdetail($id){
        $periode = tb_periode_kuesioner::where('id_periode_kuesioner', $id)->first();
        $tahun_kuesioner = tb_tahun_periode::where('id_tahun_periode', $periode->id_tahun_periode)->first()->tahun_periode;
        $periode_kuesioner = tb_periode::where('id_periode', $periode->id_periode)->first()->periode;
        $kuesioner = tb_kuesioner::where('id_periode', $id)->get();
        $tahun_periodes = tb_periode_kuesioner::with('relasiPeriodekuesionertoTahun', 'relasiPeriodekuesionertoPeriode')->get();
        $max_id_kuesioner = tb_kuesioner::max('id_kuesioner');
        $id_periode_kuesioner = $id;

            return view('/pimpinan/kuesioner/kuesioner', compact ('kuesioner','tahun_periodes','id_periode_kuesioner','tahun_kuesioner','periode_kuesioner'));
        }

    public function create(Request $request){
        $detail_kuesioner = new tb_kuesioner();
        $detail_kuesioner->type_kuesioner = $request->type_kuesioner;
        $detail_kuesioner->status = "Menunggu Konfirmasi";
        $detail_kuesioner->save();

        // tb_kuesioner::create([
        //     'type_kuesioner'=>$request->type_kuesioner,
               
        //     ]);
        return redirect('/pimpinan/kuesioner')->with('success','Data berhasil disimpan!');
    }

    public function delete($id){
        $delete = tb_kuesioner::find($id);
        $delete->delete();
        return redirect ('/pimpinan/kuesioner')->with('success','Data berhasil dihapus!'); 
    }

    public function detail($id)
    {
        $id_periode = tb_periode::max('id_periode');
        $judul_kuesioner = tb_kuesioner::find($id)->type_kuesioner;
        $periodes = tb_periode::get();
        $kuesioner = tb_jenis_kuesioner::all();

        $opsi =tb_opsi::all();

        $detail = tb_detail_kuesioner::where('id_kuesioner', $id)->get();
        $id_kuesioner = $id;

    //dd($detail);

        return view('/pimpinan/kuesioner/showkuesioner', compact('detail','kuesioner','opsi', 'id_kuesioner', 'judul_kuesioner','periodes','id_periode'));
    }
    

    public function update(Request $request){
        $res = NULL;
        $updatedata = tb_kuesioner::find($request->id_kuesioner);
        $updatedata->type_kuesioner = $request->type_kuesioner;
        $updatedata->status = $request->status;
        
        //$updatedata->enum('status', array('DiTolak','Disetujui.','Menunggu Konfirmasi'))->nullable()->change();

        $updatedata->update();
       return redirect('/pimpinan/kuesioner')->with('statusInput','Data berhasil disimpan!');
    }

    public function status($id, $status)
    {
        $detail = tb_detail_kuesioner::where('id_detail_kuesioner', $id)->first();
        $detail->status = $status;
        $detail->update();
        return response()->json(['statusInput' => 'berhasil terganti']);
    }

    public function statusall( $status)
    {
        $detailall = tb_detail_kuesioner::first();
        $detailall->status = $status;
        $detailall->update();
        return response()->json(['statusInput' => 'berhasil terganti']);
    }

    public function detailjawaban(){
        $detailjawaban = tb_jawaban::get();
        $prodi = tb_prodi::get();
        $angkatan = tb_angkatan::get();
        $alumni = tb_alumni::get();

        //dd($detailjawaban);
        return view ('/pimpinan/kuesioner/tracer', compact('detailjawaban','prodi','angkatan','alumni'));
    }


    // public function filter(Request $request)
    // {
    //     $detail = tb_detail_kuesioner::where('id_kuesioner', $request->id_kuesioner)->where('id_periode', $request->id_periode)->get();
    //     $opsi =tb_opsi::get();
    //     $hasil = view('pimpinan.kuesioner.filter', ['detail' => $detail, 'opsi' => $opsi])->render();
    //     // $hasil = $kategori;
    //     return response()->json(['success' => 'Produk difilter', 'hasil' => $hasil]);
    // }

    public function filter(Request $request)
    {
        $kuesioner = tb_kuesioner::where('id_periode', $request->id_periode)->get();
        $hasil = view('pimpinan.kuesioner.filter', ['kuesioner' => $kuesioner])->render();
        // $hasil = $kategori;
        return response()->json(['success' => 'Produk difilter', 'hasil' => $hasil]);
    }

}
