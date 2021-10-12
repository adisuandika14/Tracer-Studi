<?php

namespace App\Http\Controllers\Stakeholder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\tb_kuesioner_stackholder;
use App\tb_prodi;
use App\tb_opsi_stackholder;
use App\tb_stakeholder;

class kuesionerStakeholderController extends Controller
{

    public function index(){

        
        return view ('/stakeholder/stakeholderkuesioner');
    }

    public function datastakeholder(Request $request){
        $stakeholder = new tb_stakeholder;
        $stakeholder->nama = $request->nama;
        $stakeholder->nama_instansi = $request->nama_instansi;
        $stakeholder->jabatan = $request->jabatan;
        $stakeholder->email = $request->email;
        $stakeholder->save();
        return redirect ('/stakeholder/kuesioner/detail');
    }

    public function kuesioner(){
        $id_prodi = tb_prodi::max('id_prodi');
        $kuesioner_stakeholder = tb_kuesioner_stackholder::get();
        $prodis = tb_prodi::get();
        $opsi = tb_opsi_stackholder::get();

        return view ('/stakeholder/detailkuesioner', compact('kuesioner_stakeholder','prodis','opsi','id_prodi'));
    }

    // public function detailkuesioner(){
    //     $detail = new tb_jawaban_stakeholder;
    //     $detail->jawaban->$value;
    //     $detail->save();

    //     return redirect('/stakeholder/hasilKuesioner')->with('statusInput','Data berhasil disimpan!');

    // }


    public function filter(Request $request)
    {
        $detail = tb_kuesioner_stackholder::where('id_prodi', $request->id_prodi)->get();
        $opsi =tb_opsi_stackholder::get();
        $hasil = view('stakeholder.kuesioner.filter', ['detail' => $detail, 'opsi' => $opsi])->render();
        
        return response()->json(['success' => 'Produk difilter', 'hasil' => $hasil]);
    }
}
