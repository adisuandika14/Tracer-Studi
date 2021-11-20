<?php

namespace App\Http\Controllers\Alumni\Kuesioner;

use App\Http\Controllers\Controller;
use App\tb_jawaban;
use App\tb_periode;
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
            $kuesioners = tb_kuesioner::whereRaw('id_periode = (select max(`id_periode`) from tb_kuesioner)')->get();
            $tahun_kuesioner = \DB::table('tb_periode_kuesioner')
                ->select('periode', 'tahun_periode')
                ->join('tb_periode', 'tb_periode.id_periode', '=', 'tb_periode_kuesioner.id_periode')
                ->join('tb_tahun_periode', 'tb_tahun_periode.id_tahun_periode', '=', 'tb_periode_kuesioner.id_tahun_periode')
                ->where('tb_periode_kuesioner.id_periode_kuesioner',$kuesioners[0]->id_periode)
                ->get();
            return view('/alumni/prekuesioner', compact ('kuesioners', 'tahun_kuesioner'));
        }

//        dd($tahun_kuesioner[0]->tahun_periode);
//        return view('/alumni/prekuesioner', compact ('kuesioners', 'tahun_kuesioner'));
    }

    public function prekuesioner(Request $request)
    {
        $kuesioners = tb_kuesioner::where('id_kuesioner', $request->kuesioner)->first();
        return redirect('/alumni/kuesioner');
    }
}

