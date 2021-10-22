<?php

namespace App\Http\Controllers\Stakeholder\Kuesioner;

use App\Http\Controllers\Controller;
use App\tb_detail_jawaban;
use App\tb_jawaban_stakeholder;
use App\tb_kuesioner_stakeholder;
use App\tb_opsi_stakeholder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\tb_detail_kuesioner;
use App\tb_jawaban;
use App\tb_opsi;

class StakeholderDetailKuesionerController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth:stakeholder');
    }



    public function show(Request $request){
//        dd($request);
        $kuesioners = tb_kuesioner_stakeholder::
        where('id_prodi', '1')
            ->whereRaw('id_tahun_periode = (select max(`id_tahun_periode`) from tb_kuesioner_stakeholder)')->get();
//        dd($kuesioners);
        $opsi = tb_opsi_stakeholder::get();
        return view('/stakeholder/kuesioner', compact ('kuesioners','opsi'));
    }

    public function jawabKuesioner(Request $request){
        $kuesioners = tb_kuesioner_stakeholder::count();
        $user = (Auth::user());
        foreach($request->all() as $key => $value) {
            if($key != "_token"){
                if($key !="null"){
                    if(is_array($value)){
                        $jawaban = new tb_jawaban_stakeholder();
                        $jawaban->id_stakeholder = $user->id_stakeholder;
                        $jawaban->id_kuesioner = $key;
                        $jawaban->jawaban = "";
                        $jawaban->save();
                        $jawaban = tb_jawaban::where('id_stakeholder', $user->id_stakeholder)->where('id_detail_kuesioner', $key)->first(['id_jawaban_stakeholder']);
                        foreach($value as $jawab){
                            $detail_jawaban = new tb_detail_jawaban();
                            $detail_jawaban->id_jawaban_stakeholder=$jawaban->id_jawaban_stakeholder;
                            $detail_jawaban->jawaban = $jawab;
                            $detail_jawaban->save();
                        }
                    }else{
                        $jawaban = new tb_jawaban_stakeholder();
                        $jawaban->id_stakeholder = $user->id_stakeholder;
                        $jawaban->id_kuesioner_stakeholder = $key;
                        $jawaban->jawaban = $value;
                        $jawaban->save();
                    }
                }
            }
            // dump($key, $value);
        }
        return redirect('/stakeholder/hasilKuesioner')->with('success','Data berhasil disimpan!');
    }

    public function hasilKuesioner(){
        $user = (Auth::user()->id_stakeholder);
//        dd($user);
        $detail = tb_jawaban_stakeholder::with('relasijawabantoKuesioner')->where('id_stakeholder', $user)->get();
        $opsis = tb_opsi_stakeholder::get();
        $detail_jawaban = tb_detail_jawaban::with('relasiJawabantoOpsi')->get();

        return view('/stakeholder/hasilKuesioner',compact('detail', 'opsis', 'detail_jawaban'));
    }

    public function updateHasilKuesioner($id, Request $request){
        $jawaban = tb_jawaban_stakeholder::where('id_jawaban_stakeholder', $id)->first();
        if($request->edit_jawaban_singkat != NULL){
            $jawaban->jawaban = $request->edit_jawaban_singkat;
            $jawaban->save();
        }else if($request->save_jawaban_ganda != NULL){
            $opsi = tb_opsi_stakeholder::where('id_opsi_stakeholder', $request->save_jawaban_ganda)->first();
            $jawaban->jawaban = $opsi->opsi;
            $jawaban->save();
        }

        return back();
    }
}
