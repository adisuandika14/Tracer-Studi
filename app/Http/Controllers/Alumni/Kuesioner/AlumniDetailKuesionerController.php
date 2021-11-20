<?php

namespace App\Http\Controllers\Alumni\Kuesioner;

use App\Http\Controllers\Controller;
use App\tb_detail_jawaban;
use App\tb_kuesioner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\tb_detail_kuesioner;
use App\tb_jawaban;
use App\tb_opsi;

class AlumniDetailKuesionerController extends Controller
{
    public function __construct()
    {
        $this->middleware('reset_pass');
        $this->middleware('auth:alumni');
    }



    public function show(Request $request){
//        dd($request);
        $kuesioners = tb_detail_kuesioner::where('id_kuesioner', $request->jawabanRadio)
            ->where('status', 'Konfirmasi')->get();
        $kuesioners1 = tb_kuesioner::whereRaw('id_periode = (select max(`id_periode`) from tb_kuesioner)')
//            ->where('status', 'disetujui')
            ->get();
//        dd($kuesioners);
        $opsi = tb_opsi::get();
        $tahun_kuesioner = \DB::table('tb_periode_kuesioner')
            ->select('periode', 'tahun_periode')
            ->join('tb_periode', 'tb_periode.id_periode', '=', 'tb_periode_kuesioner.id_periode')
            ->join('tb_tahun_periode', 'tb_tahun_periode.id_tahun_periode', '=', 'tb_periode_kuesioner.id_tahun_periode')
            ->where('tb_periode_kuesioner.id_periode_kuesioner',$kuesioners1[0]->id_periode)
            ->get();

        return view('/alumni/kuesioner', compact ('kuesioners','opsi', 'tahun_kuesioner'));
    }

    public function jawabKuesioner(Request $request){
        $kuesioners = tb_detail_kuesioner::count();
        $user = (Auth::user());
        $alumni = tb_jawaban::where('id_alumni', $user->id_alumni)->first();
//        dd($alumni);
        if($alumni!=''){
            abort(403, 'Anda sudah mengisi Kuesioner.');
        }
        else{
            foreach($request->all() as $key => $value) {
                if($key != "_token"){
                    if($key !="null"){
                        if(is_array($value)){
                            $jawaban = new tb_jawaban;
                            $jawaban->id_alumni = $user->id_alumni;
                            $jawaban->id_detail_kuesioner = $key;
                            $jawaban->jawaban = "";
                            $jawaban->save();
                            $jawaban = tb_jawaban::where('id_alumni', $user->id_alumni)->where('id_detail_kuesioner', $key)->first(['id_jawaban']);
                            foreach($value as $jawab){
                                $detail_jawaban = new tb_detail_jawaban();
                                $detail_jawaban->id_jawaban=$jawaban->id_jawaban;
                                $detail_jawaban->jawaban = $jawab;
                                $detail_jawaban->save();
                            }
                        }else{
                            $jawaban = new tb_jawaban;
                            $jawaban->id_alumni = $user->id_alumni;
                            $jawaban->id_detail_kuesioner = $key;
                            $jawaban->jawaban = $value;
                            $jawaban->save();
                        }
                    }
                }
                // dump($key, $value);
            }
            return redirect('/alumni/hasilKuesioner')->with('success','Data berhasil disimpan!');
        }
    }

    public function hasilKuesioner(){
        $user = (Auth::user()->id_alumni);
//        dd($user);
        $detail = tb_jawaban::with('relasijawabantoDetail')->where('id_alumni', $user)->get();
        $opsis = tb_opsi::get();
        $detail_jawaban = tb_detail_jawaban::with('relasiJawabantoOpsi')->get();

        return view('/alumni/hasilKuesioner',compact('detail', 'opsis', 'detail_jawaban'));
    }

    public function updateHasilKuesioner($id, Request $request){
        $user = (Auth::user());
        $jawaban = tb_jawaban::where('id_jawaban', $id)->first();
        if($request->edit_jawaban_singkat != NULL){
            $jawaban->jawaban = $request->edit_jawaban_singkat;
            $jawaban->save();
        }else if($request->save_jawaban_ganda != NULL){
            $opsi = tb_opsi::where('id_opsi', $request->save_jawaban_ganda)->first();
            $jawaban->jawaban = $opsi->opsi;
            $jawaban->save();
        }else{
            $detail_jawaban = tb_detail_jawaban::where('id_jawaban', $jawaban->id_jawaban)->get();
            foreach($detail_jawaban as $detail_jawaban){
                $detail_jawaban->delete();
            }
            foreach($request->all() as $key => $value) {
                if($key != "_token"){
                    if($key !="null"){
                        if(is_array($value)) {
                            $jawaban->id_detail_kuesioner = $key;
                            $jawaban->jawaban = "";
                            $jawaban->save();
                            $jawaban = tb_jawaban::where('id_alumni', $user->id_alumni)->where('id_detail_kuesioner', $key)->first(['id_jawaban']);
                            foreach ($value as $jawab) {
                                $detail_jawaban = new tb_detail_jawaban();
                                $detail_jawaban->id_jawaban = $jawaban->id_jawaban;
                                $detail_jawaban->jawaban = $jawab;
                                $detail_jawaban->save();
                            }
                        }
                    }
                }
                // dump($key, $value);
            }
        }

        return back();
    }


//    public function delete($id){
//        $deletedata = tb_angkatan::find($id);
//        $deletedata->delete();
//        return redirect('/admin/angkatan')->with('success','Data berhasil dihapus!');
//    }
//
//    public function update(Request $request){
//        $res = NULL;
//        $updatedata = tb_angkatan::find($request->id_angkatan);
//        $updatedata->tahun_angkatan = $request->tahun_angkatan;
//        $updatedata->update();
//        //dd($updatedata);
//        return redirect('/admin/angkatan')->with('success','Data berhasil diupdate!');
//    }
}
