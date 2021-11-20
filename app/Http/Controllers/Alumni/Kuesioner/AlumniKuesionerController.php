<?php

namespace App\Http\Controllers\Alumni\Kuesioner;

use App\Alumni;
use App\Http\Controllers\Controller;
use App\tb_jawaban;
use App\tb_periode_kuesioner;
use Illuminate\Http\Request;
use App\tb_kuesioner;
use Illuminate\Support\Facades\Auth;

class AlumniKuesionerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:alumni');
        $this->middleware('reset_pass');
    }
    public function show(){
        //$angkatan = tb_angkatan::all()->groupBy('tahun_angkatan');
        $alumni = tb_jawaban::where('id_alumni', Auth::user()->id_alumni)->first();
//        dd($alumni);
        if($alumni!=''){
            return redirect('/alumni/dashboard')->with('error', 'Anda sudah mengisi kuesioner!');
//            abort(403, 'Anda sudah mengisi Kuesioner.');
        }
        else{
            $alumni = Alumni::where('id_alumni', Auth::user()->id_alumni)->first();
            $kues_aktif = tb_periode_kuesioner::where('id_periode',$alumni->id_periode)
                ->where('id_tahun_periode',$alumni->id_tahun_periode)
                ->where('status', 'Aktif')->first();
//            dd($kues_aktif);
            if($kues_aktif!=null){
                $kuesioners = tb_kuesioner::where('id_periode', $kues_aktif->id_periode_kuesioner)
                    ->where('status','Konfirmasi')->get();
//                dd($kuesioners);
                $tahun_kuesioner = \DB::table('tb_periode_kuesioner')
                    ->select('periode', 'tahun_periode')
                    ->join('tb_periode', 'tb_periode.id_periode', '=', 'tb_periode_kuesioner.id_periode')
                    ->join('tb_tahun_periode', 'tb_tahun_periode.id_tahun_periode', '=', 'tb_periode_kuesioner.id_tahun_periode')
                    ->where('tb_periode_kuesioner.id_periode_kuesioner',$kuesioners[0]->id_periode)
                    ->get();
                return view('/alumni/prekuesioner', compact ('kuesioners', 'tahun_kuesioner'));
            }
            else{
                abort(403, 'Periode kuesioner sedang tidak aktif');
            }
        }
    }

    public function prekuesioner(Request $request)
    {
        $kuesioners = tb_kuesioner::where('id_kuesioner', $request->kuesioner)->first();
        return redirect('/alumni/kuesioner');
    }
}

