<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\tb_prodi;
use App\tb_jenis_kuesioner;
use App\tb_opsi_stakeholder;
use App\tb_kuesioner_stakeholder;

class stackholderkuesionedetailController extends Controller
{
    public function detail()
    {
        $id_prodi = tb_prodi::max('id_prodi');
        $prodis = tb_prodi::get();
        $kuesioner = tb_jenis_kuesioner::get();
        $opsi =tb_opsi_stakeholder::get();
        
        $detail = tb_kuesioner_stakeholder::get(); 
        //dd($detail);
        return view('kuesioner.stakeholder.showkuesioner', compact('detail','kuesioner','opsi', 'id_prodi','prodis'));
    }


    public function filter(Request $request)
    {
        $detail = tb_kuesioner_stakeholder::where('id_prodi', $request->id_prodi)->get();
        $opsi =tb_opsi_stakeholder::get();
        $hasil = view('kuesioner.stakeholder.filter', ['detail' => $detail, 'opsi' => $opsi])->render();
        // $hasil = $kategori;
        return response()->json(['success' => 'Produk difilter', 'hasil' => $hasil]);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'id_jenis' => 'required', 
            'pertanyaan' => 'required',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator);
        }

        $kuesioner_stakeholder = new tb_kuesioner_stakeholder();

        if($request->id_jenis ==  2){
            $kuesioner_stakeholder->id_prodi = $request->id_prodi;
            $kuesioner_stakeholder->id_jenis = 2;
            $kuesioner_stakeholder->pertanyaan = $request->pertanyaan;
            $kuesioner_stakeholder->save();
        }

        if($request->id_jenis == 1 || $request->id_jenis == 3){
            $kuesioner_stakeholder->id_prodi = $request->id_prodi;
            $kuesioner_stakeholder->id_jenis = $request->id_jenis;
            $kuesioner_stakeholder->pertanyaan = $request->pertanyaan;
            $kuesioner_stakeholder->save();

            $kuesioner_stakeholder = tb_kuesioner_stakeholder::find(tb_kuesioner_stakeholder::max('id_kuesioner_stakeholder'));
            if($request->opsi1 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->opsi1;
                $opsi->id_kuesioner_stakeholder = $kuesioner_stakeholder->id_kuesioner_stakeholder;
                $opsi->save();
            }

            if($request->opsi2 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->opsi2;
                $opsi->id_kuesioner_stakeholder = $kuesioner_stakeholder->id_kuesioner_stakeholder;
                $opsi->save();
            }

            if($request->opsi3 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->opsi3;
                $opsi->id_kuesioner_stakeholder = $kuesioner_stakeholder->id_kuesioner_stakeholder;
                $opsi->save();
            }

            if($request->opsi4 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->opsi4;
                $opsi->id_kuesioner_stakeholder = $kuesioner_stakeholder->id_kuesioner_stakeholder;
                $opsi->save();
            }

            if($request->opsi5 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->opsi5;
                $opsi->id_kuesioner_stakeholder = $kuesioner_stakeholder->id_kuesioner_stakeholder;
                $opsi->save();
            }
            if($request->opsi6 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->opsi6;
                $opsi->id_kuesioner_stakeholder = $kuesioner_stakeholder->id_kuesioner_stakeholder;
                $opsi->save();
            }
            if($request->opsi7 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->opsi7;
                $opsi->id_kuesioner_stakeholder = $kuesioner_stakeholder->id_kuesioner_stakeholder;
                $opsi->save();
            }
            if($request->opsi8 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->opsi8;
                $opsi->id_kuesioner_stakeholder = $kuesioner_stakeholder->id_kuesioner_stakeholder;
                $opsi->save();
            }
            if($request->opsi9 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->opsi9;
                $opsi->id_kuesioner_stakeholder = $kuesioner_stakeholder->id_kuesioner_stakeholder;
                $opsi->save();
            }
            if($request->opsi10 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->opsi10;
                $opsi->id_kuesioner_stakeholder = $kuesioner_stakeholder->id_kuesioner_stakeholder;
                $opsi->save();
            }
        }

        return redirect()->route('stakeholder-kuesioner-show', $request->id_kuesioner)->with('statusInput', 'Pertanyaan berhasil ditambahkan');
    }

    public function delete($id)
    {
        $kuesioner_stakeholder = tb_kuesioner_stakeholder::find($id);
        $kuesioner_stakeholder->delete();

        $opsis = tb_opsi_stakeholder::get();
        foreach($opsis as $opsi){
            if($opsi->id_kuesioner_stakeholder == $id){
                $opsi->delete();
            }
        }
        return back()->with('statusInput', 'Pertanyaan berhasil dihapus');
    }


    public function edit($id)
    {
        $kuesioner_stakeholder = tb_kuesioner_stakeholder::find($id);
        $opsis = tb_opsi_stakeholder::where('id_kuesioner_stakeholder', $kuesioner_stakeholder->id_kuesioner_stakeholder)->get();
        return response()->json(['success' => 'Berhasil', 'detail_kuesioner' => $kuesioner_stakeholder, 'opsis' => $opsis]);
    }

    public function update($id, Request $request){
        $validator = Validator::make($request->all(), [
            'edit_id_jenis' => 'required',
            'edit_pertanyaan' => 'required',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator);
        }

        

        $kuesioner_stakeholder = tb_kuesioner_stakeholder::find($id);

        $opsis = tb_opsi_stakeholder::get();
        foreach($opsis as $opsi){
            if($opsi->id_kuesioner_stakeholder == $id){
                $opsi->delete();
            }
        }

        if($request->edit_id_jenis ==  2){
            $kuesioner_stakeholder->id_prodi = $request->id_prodi;
            $kuesioner_stakeholder->id_jenis = 2;
            $kuesioner_stakeholder->pertanyaan = $request->edit_pertanyaan;
            $kuesioner_stakeholder->update();
        }

        if($request->edit_id_jenis == 1 || $request->edit_id_jenis == 3){
            $kuesioner_stakeholder->id_prodi = $request->id_prodi;
            $kuesioner_stakeholder->id_jenis = 1;
            $kuesioner_stakeholder->pertanyaan = $request->edit_pertanyaan;
            $kuesioner_stakeholder->update();

            if($request->edit_opsi1 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->edit_opsi1;
                $opsi->id_kuesioner_stakeholder = $kuesioner_stakeholder->id_kuesioner_stakeholder;
                $opsi->save();
            }

            if($request->edit_opsi2 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->edit_opsi2;
                $opsi->id_kuesioner_stakeholder = $kuesioner_stakeholder->id_kuesioner_stakeholder;
                $opsi->save();
            }

            if($request->edit_opsi3 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->edit_opsi3;
                $opsi->id_kuesioner_stakeholder = $kuesioner_stakeholder->id_kuesioner_stakeholder;
                $opsi->save();
            }

            if($request->edit_opsi4 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->edit_opsi4;
                $opsi->id_kuesioner_stakeholder = $kuesioner_stakeholder->id_kuesioner_stakeholder;
                $opsi->save();
            }

            if($request->edit_opsi5 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->edit_opsi5;
                $opsi->id_kuesioner_stakeholder = $kuesioner_stakeholder->id_kuesioner_stakeholder;
                $opsi->save();
            }
            if($request->edit_opsi6 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->edit_opsi6;
                $opsi->id_kuesioner_stakeholder = $kuesioner_stakeholder->id_kuesioner_stakeholder;
                $opsi->save();
            }
            if($request->edit_opsi7 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->edit_opsi7;
                $opsi->id_kuesioner_stakeholder = $kuesioner_stakeholder->id_kuesioner_stakeholder;
                $opsi->save();
            }
            if($request->edit_opsi8 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->edit_opsi8;
                $opsi->id_kuesioner_stakeholder = $kuesioner_stakeholder->id_kuesioner_stakeholder;
                $opsi->save();
            }
            if($request->edit_opsi9 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->edit_opsi9;
                $opsi->id_kuesioner_stakeholder = $kuesioner_stakeholder->id_kuesioner_stakeholder;
                $opsi->save();
            }
            if($request->edit_opsi10 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->edit_opsi10;
                $opsi->id_kuesioner_stakeholder = $kuesioner_stakeholder->id_kuesioner_stakeholder;
                $opsi->save();
            }
        }

        return redirect()->route('stakeholder-kuesioner-show', $request->id_kuesioner_stakeholder)->with('statusInput', 'Pertanyaan berhasil diperbaharui');
    }


}
