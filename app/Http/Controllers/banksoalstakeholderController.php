<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\tb_soal_stakeholder;
use App\tb_opsi_soal_stakeholder;
use App\tb_jenis_kuesioner;
use App\tb_prodi;
use App\tb_tahun_periode;


class banksoalstakeholderController extends Controller
{
    public function show()
    {
        $max_id_soal = tb_prodi::get();
        $id_prodi = tb_soal_stakeholder::where('id_soal_stakeholder', $max_id_soal)->first(['id_prodi']);
        $prodis = tb_prodi::get();

        $detail = tb_soal_stakeholder::where('id_prodi', $id_prodi)->get();
        $opsi = tb_opsi_soal_stakeholder::get();

        return view('/BankSoal/banksoalstakeholder', compact('detail','opsi','prodis','id_prodi'));
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'id_jenis' => 'required', 
            'pertanyaan' => 'required',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator);
        }

        $bank_soal = new tb_soal_stakeholder();

        if($request->id_jenis ==  2){
            $bank_soal->id_jenis = 2;
            $bank_soal->id_prodi = $request->id_prodi;
            $bank_soal->pertanyaan = $request->pertanyaan;
            $bank_soal->save();
        }

        if($request->id_jenis ==  4){
            $bank_soal->id_jenis = 4;
            $bank_soal->id_prodi = $request->id_prodi;
            $bank_soal->pertanyaan = $request->pertanyaan;
            $bank_soal->save();
        }

        if($request->id_jenis == 1 || $request->id_jenis == 3){
            $bank_soal->id_jenis = $request->id_jenis;
            $bank_soal->id_prodi = $request->id_prodi;
            $bank_soal->pertanyaan = $request->pertanyaan;
            $bank_soal->save();

            $bank_soal = tb_soal_stakeholder::find(tb_soal_stakeholder::max('id_soal_stakeholder'));
            if($request->opsi1 != ""){
                $opsi = new tb_opsi_soal_stakeholder();
                $opsi->opsi = $request->opsi1;
                $opsi->id_soal_stakeholder = $bank_soal->id_soal_stakeholder;
                $opsi->save();
            }

            if($request->opsi2 != ""){
                $opsi = new tb_opsi_soal_stakeholder();
                $opsi->opsi = $request->opsi2;
                $opsi->id_soal_stakeholder = $bank_soal->id_soal_stakeholder;
                $opsi->save();
            }

            if($request->opsi3 != ""){
                $opsi = new tb_opsi_soal_stakeholder();
                $opsi->opsi = $request->opsi3;
                $opsi->id_soal_stakeholder = $bank_soal->id_soal_stakeholder;
                $opsi->save();
            }

            if($request->opsi4 != ""){
                $opsi = new tb_opsi_soal_stakeholder();
                $opsi->opsi = $request->opsi4;
                $opsi->id_soal_stakeholder = $bank_soal->id_soal_stakeholder;
                $opsi->save();
            }

            if($request->opsi5 != ""){
                $opsi = new tb_opsi_soal_stakeholder();
                $opsi->opsi = $request->opsi5;
                $opsi->id_soal_stakeholder = $bank_soal->id_soal_stakeholder;
                $opsi->save();
            }
            if($request->opsi6 != ""){
                $opsi = new tb_opsi_soal_stakeholder();
                $opsi->opsi = $request->opsi6;
                $opsi->id_soal_stakeholder = $bank_soal->id_soal_stakeholder;
                $opsi->save();
            }
            if($request->opsi7 != ""){
                $opsi = new tb_opsi_soal_stakeholder();
                $opsi->opsi = $request->opsi7;
                $opsi->id_soal_stakeholder = $bank_soal->id_soal_stakeholder;
                $opsi->save();
            }
            if($request->opsi8 != ""){
                $opsi = new tb_opsi_soal_stakeholder();
                $opsi->opsi = $request->opsi8;
                $opsi->id_soal_stakeholder = $bank_soal->id_soal_stakeholder;
                $opsi->save();
            }
            if($request->opsi9 != ""){
                $opsi = new tb_opsi_soal_stakeholder();
                $opsi->opsi = $request->opsi9;
                $opsi->id_soal_stakeholder = $bank_soal->id_soal_stakeholder;
                $opsi->save();
            }
            if($request->opsi10 != ""){
                $opsi = new tb_opsi_soal_stakeholder();
                $opsi->opsi = $request->opsi10;
                $opsi->id_soal_stakeholder = $bank_soal->id_soal_stakeholder;
                $opsi->save();
            }
        }

        return redirect()->route('show-banksoal-stakeholder')->with('statusInput', 'Pertanyaan berhasil ditambahkan');
    }

    public function delete($id)
    {
        $detail_kuesioner = tb_soal_stakeholder::find($id);
        $detail_kuesioner->delete();

        $opsis = tb_opsi_soal_stakeholder::get();
        foreach($opsis as $opsi){
            if($opsi->id_soal_stakeholder == $id){
                $opsi->delete();
            }
        }
        return back()->with('statusInput', 'Pertanyaan berhasil dihapus');
    }

    public function edit($id)
    {
        $bank_soal = tb_soal_stakeholder::find($id);
        $opsis = tb_opsi_soal_stakeholder::where('id_soal_stakeholder', $bank_soal->id_soal_stakeholder)->get();
        return response()->json(['success' => 'Berhasil', 'bank_soal' => $bank_soal, 'opsis' => $opsis]);
    }

    public function update($id, Request $request){
        $validator = Validator::make($request->all(), [
            'edit_id_jenis' => 'required', 
            'edit_pertanyaan' => 'required',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator);
        }

        $bank_soal = tb_soal_stakeholder::find($id);

        $opsis = tb_opsi_soal_stakeholder::get();
        foreach($opsis as $opsi){
            if($opsi->id_soal_stakeholder == $id){
                $opsi->delete();
            }
        }

        if($request->edit_id_jenis ==  2){
            $bank_soal->id_jenis = 2;
            $bank_soal->pertanyaan = $request->edit_pertanyaan;
            $bank_soal->update();
        }

        if($request->edit_id_jenis ==  4){
            $bank_soal->id_jenis = 4;
            $bank_soal->pertanyaan = $request->edit_pertanyaan;
            $bank_soal->update();
        }

        if($request->edit_id_jenis == 1 || $request->edit_id_jenis == 3){
            $bank_soal->id_jenis = $request->id_jenis;
            $bank_soal->pertanyaan = $request->edit_pertanyaan;
            $bank_soal->update();

            $bank_soal = tb_soal_stakeholder::find(tb_soal_stakeholder::max('id_soal_stakeholder'));
            if($request->opsi1 != ""){
                $opsi = new tb_opsi_soal_stakeholder();
                $opsi->opsi = $request->opsi1;
                $opsi->id_soal_stakeholder = $bank_soal->id_soal_stakeholder;
                $opsi->save();
            }

            if($request->opsi2 != ""){
                $opsi = new tb_opsi_soal_stakeholder();
                $opsi->opsi = $request->opsi2;
                $opsi->id_soal_stakeholder = $bank_soal->id_soal_stakeholder;
                $opsi->save();
            }

            if($request->opsi3 != ""){
                $opsi = new tb_opsi_soal_stakeholder();
                $opsi->opsi = $request->opsi3;
                $opsi->id_soal_stakeholder = $bank_soal->id_soal_stakeholder;
                $opsi->save();
            }

            if($request->opsi4 != ""){
                $opsi = new tb_opsi_soal_stakeholder();
                $opsi->opsi = $request->opsi4;
                $opsi->id_soal_stakeholder = $bank_soal->id_soal_stakeholder;
                $opsi->save();
            }

            if($request->opsi5 != ""){
                $opsi = new tb_opsi_soal_stakeholder();
                $opsi->opsi = $request->opsi5;
                $opsi->id_soal_stakeholder = $bank_soal->id_soal_stakeholder;
                $opsi->save();
            }
            if($request->opsi6 != ""){
                $opsi = new tb_opsi_soal_stakeholder();
                $opsi->opsi = $request->opsi6;
                $opsi->id_soal_stakeholder = $bank_soal->id_soal_stakeholder;
                $opsi->save();
            }
            if($request->opsi7 != ""){
                $opsi = new tb_opsi_soal_stakeholder();
                $opsi->opsi = $request->opsi7;
                $opsi->id_soal_stakeholder = $bank_soal->id_soal_stakeholder;
                $opsi->save();
            }
            if($request->opsi8 != ""){
                $opsi = new tb_opsi_soal_stakeholder();
                $opsi->opsi = $request->opsi8;
                $opsi->id_soal_stakeholder = $bank_soal->id_soal_stakeholder;
                $opsi->save();
            }
            if($request->opsi9 != ""){
                $opsi = new tb_opsi_soal_stakeholder();
                $opsi->opsi = $request->opsi9;
                $opsi->id_soal_stakeholder = $bank_soal->id_soal_stakeholder;
                $opsi->save();
            }
            if($request->opsi10 != ""){
                $opsi = new tb_opsi_soal_stakeholder();
                $opsi->opsi = $request->opsi10;
                $opsi->id_soal_stakeholder = $bank_soal->id_soal_stakeholder;
                $opsi->save();
            }
        }

        return redirect()->route('show-banksoal-stakeholder')->with('statusInput', 'Pertanyaan berhasil ditambahkan');
    }

    public function filter(Request $request)
    {
        $detail = tb_soal_stakeholder::where('id_prodi', $request->id_prodi)->get();
        $opsi =tb_opsi_soal_stakeholder::get();
        $hasil = view('BankSoal.filterstakeholder', ['detail' => $detail, 'opsi' => $opsi])->render();
        // $hasil = $kategori;
        return response()->json(['success' => 'Produk difilter', 'hasil' => $hasil]);
    }
}
