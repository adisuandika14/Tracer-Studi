<?php

namespace App\Http\Controllers\Alumni\Kuesioner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\tb_kuesioner;

class AlumniKuesionerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:alumni');
    }
    public function show(){
        //$angkatan = tb_angkatan::all()->groupBy('tahun_angkatan');

        $kuesioners = tb_kuesioner::get();

        // dd($alumni);
        return view('/alumni/prekuesioner', compact ('kuesioners'));
    }

    public function prekuesioner(Request $request)
    {
        $kuesioners = tb_kuesioner::where('id_kuesioner', $request->kuesioner)->first();
        return redirect('/alumni/kuesioner');
    }
}

