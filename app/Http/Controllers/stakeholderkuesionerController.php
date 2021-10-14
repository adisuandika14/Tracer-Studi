<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\tb_tahun_periode;
use App\tb_prodi;

class stakeholderkuesionerController extends Controller
{
    public function show(){
        $id_tahun_periode = tb_tahun_periode::max('id_tahun_periode');
        $periode = tb_tahun_periode::get();
        $prodi = tb_prodi::get();

        return view('kuesioner/stakeholder/kuesionerstakeholder', compact('id_tahun_periode','periode','prodi'));
    }

    public function filter(Request $request)
    {
        $detail = tb_kuesioner_stakeholder::where('id_tahun_periode', $request->id_tahun_periode)->get();
        $hasil = view('kuesioner.stakeholder.filterkuesioner', ['detail' => $detail])->render();
        // $hasil = $kategori;
        return response()->json(['success' => 'Produk difilter', 'hasil' => $hasil]);
    }
}
