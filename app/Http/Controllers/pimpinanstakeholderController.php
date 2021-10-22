<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\tb_tahun_periode;
use App\tb_prodi;
use App\tb_kuesioner_stakeholder;
use App\tb_opsi_stakeholder;

class pimpinanstakeholderController extends Controller
{
    public function show(){
        $id_tahun_periode = tb_tahun_periode::max('id_tahun_periode');
        $periode = tb_tahun_periode::get();
        $prodi = tb_prodi::get();

        return view('pimpinan/kuesioner/kuesionerstakeholder', compact('id_tahun_periode','periode','prodi'));
    }

    
    public function filter(Request $request)
    {
        $detail = tb_prodi::get();
        $hasil = view('pimpinan.kuesioner.filterstakeholder', ['detail' => $detail])->render();
        // $hasil = $kategori;
        return response()->json(['success' => 'Produk difilter', 'hasil' => $hasil]);
    }

    public function detail_kuesioner($id_prodi, $id_periode){
        $detail = tb_kuesioner_stakeholder::where('id_prodi', $id_prodi)->where('id_tahun_periode', $id_periode)->get();
        $opsi =tb_opsi_stakeholder::get();
        $tahun = tb_tahun_periode::find($id_periode)->tahun_periode;
        $prodi = tb_prodi::find($id_prodi)->nama_prodi;
        return view('pimpinan/kuesioner/stakeholderdetail', compact('detail', 'id_prodi', 'id_periode', 'opsi','tahun','prodi'));
    }
    
    public function status($id, $status)
    {
        $detail = tb_periode::where('id_periode', $id)->first();
        $detail->status = $status;
        $detail->update();
        return response()->json(['statusInput' => 'berhasil terganti']);
    }

}
