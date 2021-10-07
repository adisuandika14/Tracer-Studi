<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\tb_prodi;
use App\tb_jenis_kuesioner;
use App\tb_opsi_stackholder;
use App\tb_kuesioner_stackholder;

class stackholderkuesionerController extends Controller
{
    public function detail()
    {
        $id_prodi = tb_prodi::max('id_prodi');
        $prodis = tb_prodi::get();
        $kuesioner = tb_jenis_kuesioner::get();
        $opsi =tb_opsi_stackholder::get();
        
        $detail = tb_kuesioner_stackholder::get(); 
        //dd($detail);
        return view('kuesioner.stackholder.showkuesioner', compact('detail','kuesioner','opsi', 'id_prodi','prodis'));
    }


    public function filter(Request $request)
    {
        $detail = tb_kuesioner_stackholder::where('id_prodi', $request->id_prodi)->get();
        $opsi =tb_opsi_stackholder::get();
        $hasil = view('kuesioner.filter', ['detail' => $detail, 'opsi' => $opsi])->render();
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

        $kuesioner_stackholder = new tb_kuesioner_stackholder();

        if($request->id_jenis ==  2){
            $kuesioner_stackholder->id_prodi = $request->id_prodi;
            $kuesioner_stackholder->id_jenis = 2;
            $kuesioner_stackholder->pertanyaan = $request->pertanyaan;
            //$kuesioner_stackholder->status = "Menunggu Konfirmasi";
            $kuesioner_stackholder->save();
        }

        if($request->id_jenis == 1 || $request->id_jenis == 3){
            $kuesioner_stackholder->id_prodi = $request->id_prodi;
            $kuesioner_stackholder->id_jenis = $request->id_jenis;
            $kuesioner_stackholder->pertanyaan = $request->pertanyaan;
           // $kuesioner_stackholder->status = "Menunggu Konfirmasi";
            $kuesioner_stackholder->save();

            $kuesioner_stackholder = tb_kuesioner_stackholder::find(tb_kuesioner_stackholder::max('id_kuesioner_stackholder'));
            if($request->opsi1 != ""){
                $opsi = new tb_opsi_stackholder();
                $opsi->opsi = $request->opsi1;
                $opsi->id_kuesioner_stackholder = $kuesioner_stackholder->id_kuesioner_stackholder;
                $opsi->save();
            }

            if($request->opsi2 != ""){
                $opsi = new tb_opsi_stackholder();
                $opsi->opsi = $request->opsi2;
                $opsi->id_kuesioner_stackholder = $kuesioner_stackholder->id_kuesioner_stackholder;
                $opsi->save();
            }

            if($request->opsi3 != ""){
                $opsi = new tb_opsi_stackholder();
                $opsi->opsi = $request->opsi3;
                $opsi->id_kuesioner_stackholder = $kuesioner_stackholder->id_kuesioner_stackholder;
                $opsi->save();
            }

            if($request->opsi4 != ""){
                $opsi = new tb_opsi_stackholder();
                $opsi->opsi = $request->opsi4;
                $opsi->id_kuesioner_stackholder = $kuesioner_stackholder->id_kuesioner_stackholder;
                $opsi->save();
            }

            if($request->opsi5 != ""){
                $opsi = new tb_opsi_stackholder();
                $opsi->opsi = $request->opsi5;
                $opsi->id_kuesioner_stackholder = $kuesioner_stackholder->id_kuesioner_stackholder;
                $opsi->save();
            }
            if($request->opsi6 != ""){
                $opsi = new tb_opsi_stackholder();
                $opsi->opsi = $request->opsi6;
                $opsi->id_kuesioner_stackholder = $kuesioner_stackholder->id_kuesioner_stackholder;
                $opsi->save();
            }
            if($request->opsi7 != ""){
                $opsi = new tb_opsi_stackholder();
                $opsi->opsi = $request->opsi7;
                $opsi->id_kuesioner_stackholder = $kuesioner_stackholder->id_kuesioner_stackholder;
                $opsi->save();
            }
            if($request->opsi8 != ""){
                $opsi = new tb_opsi_stackholder();
                $opsi->opsi = $request->opsi8;
                $opsi->id_kuesioner_stackholder = $kuesioner_stackholder->id_kuesioner_stackholder;
                $opsi->save();
            }
            if($request->opsi9 != ""){
                $opsi = new tb_opsi_stackholder();
                $opsi->opsi = $request->opsi9;
                $opsi->id_kuesioner_stackholder = $kuesioner_stackholder->id_kuesioner_stackholder;
                $opsi->save();
            }
            if($request->opsi10 != ""){
                $opsi = new tb_opsi_stackholder();
                $opsi->opsi = $request->opsi10;
                $opsi->id_kuesioner_stackholder = $kuesioner_stackholder->id_kuesioner_stackholder;
                $opsi->save();
            }
        }

        return redirect()->route('stackholder-kuesioner-show', $request->id_kuesioner)->with('statusInput', 'Pertanyaan berhasil ditambahkan');
    }

    public function delete($id)
    {
        $kuesioner_stackholder = tb_kuesioner_stackholder::find($id);
        $kuesioner_stackholder->delete();

        $opsis = tb_opsi_stackholder::get();
        foreach($opsis as $opsi){
            if($opsi->id_kuesioner_stackholder == $id){
                $opsi->delete();
            }
        }
        return back()->with('statusInput', 'Pertanyaan berhasil dihapus');
    }


    public function edit($id)
    {
        $kuesioner_stackholder = tb_kuesioner_stackholder::find($id);
        $opsis = tb_opsi_stackholder::where('id_kuesioner_stackholder', $kuesioner_stackholder->id_kuesioner_stackholder)->get();
        return response()->json(['success' => 'Berhasil', 'kuesioner_stackholder' => $kuesioner_stackholder, 'opsis' => $opsis]);
    }

    public function update($id, Request $request){
        $validator = Validator::make($request->all(), [
            'edit_id_jenis' => 'required',
            'edit_pertanyaan' => 'required',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator);
        }

        

        $kuesioner_stackholder = tb_kuesioner_stackholder::find($id);

        $opsis = tb_opsi_stackholder::get();
        foreach($opsis as $opsi){
            if($opsi->id_kuesioner_stackholder == $id){
                $opsi->delete();
            }
        }

        if($request->edit_id_jenis ==  2){
            $kuesioner_stackholder->id_periode = $request->id_periode;
            $kuesioner_stackholder->id_jenis = 2;
            $kuesioner_stackholder->pertanyaan = $request->edit_pertanyaan;
            $kuesioner_stackholder->update();
        }

        if($request->edit_id_jenis == 1 || $request->edit_id_jenis == 3){
            $kuesioner_stackholder->id_periode = $request->id_periode;
            $kuesioner_stackholder->id_jenis = 1;
            $kuesioner_stackholder->pertanyaan = $request->edit_pertanyaan;
            $kuesioner_stackholder->update();

            if($request->edit_opsi1 != ""){
                $opsi = new tb_opsi_stackholder();
                $opsi->opsi = $request->edit_opsi1;
                $opsi->id_kuesioner_stackholder = $kuesioner_stackholder->id_kuesioner_stackholder;
                $opsi->save();
            }

            if($request->edit_opsi2 != ""){
                $opsi = new tb_opsi_stackholder();
                $opsi->opsi = $request->edit_opsi2;
                $opsi->id_kuesioner_stackholder = $kuesioner_stackholder->id_kuesioner_stackholder;
                $opsi->save();
            }

            if($request->edit_opsi3 != ""){
                $opsi = new tb_opsi_stackholder();
                $opsi->opsi = $request->edit_opsi3;
                $opsi->id_kuesioner_stackholder = $kuesioner_stackholder->id_kuesioner_stackholder;
                $opsi->save();
            }

            if($request->edit_opsi4 != ""){
                $opsi = new tb_opsi_stackholder();
                $opsi->opsi = $request->edit_opsi4;
                $opsi->id_kuesioner_stackholder = $kuesioner_stackholder->id_kuesioner_stackholder;
                $opsi->save();
            }

            if($request->edit_opsi5 != ""){
                $opsi = new tb_opsi_stackholder();
                $opsi->opsi = $request->edit_opsi5;
                $opsi->id_kuesioner_stackholder = $kuesioner_stackholder->id_kuesioner_stackholder;
                $opsi->save();
            }
            if($request->edit_opsi6 != ""){
                $opsi = new tb_opsi_stackholder();
                $opsi->opsi = $request->edit_opsi6;
                $opsi->id_kuesioner_stackholder = $kuesioner_stackholder->id_kuesioner_stackholder;
                $opsi->save();
            }
            if($request->edit_opsi7 != ""){
                $opsi = new tb_opsi_stackholder();
                $opsi->opsi = $request->edit_opsi7;
                $opsi->id_kuesioner_stackholder = $kuesioner_stackholder->id_kuesioner_stackholder;
                $opsi->save();
            }
            if($request->edit_opsi8 != ""){
                $opsi = new tb_opsi_stackholder();
                $opsi->opsi = $request->edit_opsi8;
                $opsi->id_kuesioner_stackholder = $kuesioner_stackholder->id_kuesioner_stackholder;
                $opsi->save();
            }
            if($request->edit_opsi9 != ""){
                $opsi = new tb_opsi_stackholder();
                $opsi->opsi = $request->edit_opsi9;
                $opsi->id_kuesioner_stackholder = $kuesioner_stackholder->id_kuesioner_stackholder;
                $opsi->save();
            }
            if($request->edit_opsi10 != ""){
                $opsi = new tb_opsi_stackholder();
                $opsi->opsi = $request->edit_opsi10;
                $opsi->id_kuesioner_stackholder = $kuesioner_stackholder->id_kuesioner_stackholder;
                $opsi->save();
            }
        }

        return redirect()->route('stackholder-kuesioner-show', $request->id_kuesioner_stackholder)->with('statusInput', 'Pertanyaan berhasil diperbaharui');
    }


}
