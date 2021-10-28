<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\tb_soal_alumni;
use App\tb_jenis_kuesioner;
use App\tb_detail_soal_alumni;
use App\tb_opsi_bank_soal_alumni;
use App\tb_bank_soal_alumni;

class banksoalalumnidetailController extends Controller
{
    public function detail($id)
    {
        $judul_kuesioner = tb_soal_alumni::find($id)->pertanyaan;
        $kuesioner = tb_jenis_kuesioner::get();
        $opsi =tb_opsi_bank_soal_alumni::get();

        $detail = tb_detail_soal_alumni::where('id_soal_alumni', $id)->get();
        $id_soal_alumni = $id;
        //dd($detail);
        return view('/BankSoal/detailbanksoalalumni', compact('detail','kuesioner','opsi', 'id_soal_alumni', 'judul_kuesioner'));
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'pertanyaan' => 'required',
            'id_jenis'=>'required',
        ],[
             'pertanyaan.required' => "Anda Belum Menambahkan Kuesioner",
             'id_jenis.required' => "Anda Belum memilih jenis kuesioner",
         ]);

        if($validator->fails()){
            return back()->withErrors($validator);
        }

        $detail_kuesioner = new tb_detail_soal_alumni();

        if($request->id_jenis ==  2){
            $detail_kuesioner->id_soal_alumni = $request->id_soal_alumni;
            $detail_kuesioner->id_jenis = 2;
            $detail_kuesioner->pertanyaan = $request->pertanyaan;
            $detail_kuesioner->status = "Menunggu Konfirmasi";
            $detail_kuesioner->save();
        }

        if($request->id_jenis ==  4){
            $detail_kuesioner->id_soal_alumni = $request->id_soal_alumni;
            $detail_kuesioner->id_jenis = 4;
            $detail_kuesioner->pertanyaan = $request->pertanyaan;
            $detail_kuesioner->status = "Menunggu Konfirmasi";
            $detail_kuesioner->save();
        }

        if($request->id_jenis == 1 || $request->id_jenis == 3){
            $detail_kuesioner->id_soal_alumni = $request->id_soal_alumni;
            $detail_kuesioner->id_jenis = $request->id_jenis;
            $detail_kuesioner->pertanyaan = $request->pertanyaan;
            $detail_kuesioner->status = "Menunggu Konfirmasi";
            $detail_kuesioner->save();

            $detail_kuesioner = tb_detail_soal_alumni::find(tb_detail_soal_alumni::max('id_detail_soal_alumni'));
            if($request->opsi1 != ""){
                $opsi = new tb_opsi_bank_soal_alumni();
                $opsi->opsi = $request->opsi1;
                $opsi->id_soal_alumni = $detail_kuesioner->id_detail_soal_alumni;
                $opsi->save();
            }

            if($request->opsi2 != ""){
                $opsi = new tb_opsi_bank_soal_alumni();
                $opsi->opsi = $request->opsi2;
                $opsi->id_soal_alumni = $detail_kuesioner->id_detail_soal_alumni;
                $opsi->save();
            }

            if($request->opsi3 != ""){
                $opsi = new tb_opsi_bank_soal_alumni();
                $opsi->opsi = $request->opsi3;
                $opsi->id_soal_alumni = $detail_kuesioner->id_detail_soal_alumni;
                $opsi->save();
            }

            if($request->opsi4 != ""){
                $opsi = new tb_opsi_bank_soal_alumni();
                $opsi->opsi = $request->opsi4;
                $opsi->id_soal_alumni = $detail_kuesioner->id_detail_soal_alumni;
                $opsi->save();
            }

            if($request->opsi5 != ""){
                $opsi = new tb_opsi_bank_soal_alumni();
                $opsi->opsi = $request->opsi5;
                $opsi->id_soal_alumni = $detail_kuesioner->id_detail_soal_alumni;
                $opsi->save();
            }
            if($request->opsi6 != ""){
                $opsi = new tb_opsi_bank_soal_alumni();
                $opsi->opsi = $request->opsi6;
                $opsi->id_soal_alumni = $detail_kuesioner->id_detail_soal_alumni;
                $opsi->save();
            }
            if($request->opsi7 != ""){
                $opsi = new tb_opsi_bank_soal_alumni();
                $opsi->opsi = $request->opsi7;
                $opsi->id_soal_alumni = $detail_kuesioner->id_detail_soal_alumni;
                $opsi->save();
            }
            if($request->opsi8 != ""){
                $opsi = new tb_opsi_bank_soal_alumni();
                $opsi->opsi = $request->opsi8;
                $opsi->id_soal_alumni = $detail_kuesioner->id_detail_soal_alumni;
                $opsi->save();
            }
            if($request->opsi9 != ""){
                $opsi = new tb_opsi_bank_soal_alumni();
                $opsi->opsi = $request->opsi9;
                $opsi->id_soal_alumni = $detail_kuesioner->id_detail_soal_alumni;
                $opsi->save();
            }
            if($request->opsi10 != ""){
                $opsi = new tb_opsi_bank_soal_alumni();
                $opsi->opsi = $request->opsi10;
                $opsi->id_soal_alumni = $detail_kuesioner->id_detail_soal_alumni;
                $opsi->save();
            }
        }

        return redirect()->route('show-banksoalalumni', $request->id_soal_alumni)->with('statusInput', 'Pertanyaan berhasil ditambahkan');
    }


    public function edit($id)
    {
        $detail_soal = tb_detail_soal_alumni::find($id);
        $opsis = tb_opsi_bank_soal_alumni::where('id_soal_alumni', $detail_soal->id_detail_soal_alumni)->get();
        return response()->json(['success' => 'Berhasil', 'detail_soal' => $detail_soal, 'opsis' => $opsis]);
    }

    public function update($id, Request $request){
        $validator = Validator::make($request->all(), [
            'edit_id_jenis' => 'required',
            'edit_pertanyaan' => 'required',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator);
        }

        

        $detail_soal = tb_detail_soal_alumni::find($id);

        $opsis = tb_opsi_bank_soal_alumni::get();
        foreach($opsis as $opsi){
            if($opsi->id_soal_alumni == $id){
                $opsi->delete();
            }
        }

        if($request->edit_id_jenis ==  2){
            $detail_soal->id_soal_alumni = $request->id_soal_alumni;
            $detail_soal->id_jenis = 2;
            $detail_soal->pertanyaan = $request->edit_pertanyaan;
            $detail_soal->status = "Menunggu Konfirmasi";
            $detail_soal->update();
        }

        if($request->edit_id_jenis == 1 || $request->edit_id_jenis == 3){
            $detail_soal->id_soal_alumni = $request->id_soal_alumni;
            $detail_soal->id_jenis = 1;
            $detail_soal->pertanyaan = $request->edit_pertanyaan;
            $detail_soal->status = "Menunggu Konfirmasi";
            $detail_soal->update();

            if($request->edit_opsi1 != ""){
                $opsi = new tb_opsi_bank_soal_alumni();
                $opsi->opsi = $request->edit_opsi1;
                $opsi->id_soal_alumni = $detail_soal->id_detail_soal_alumni;
                $opsi->save();
            }

            if($request->edit_opsi2 != ""){
                $opsi = new tb_opsi_bank_soal_alumni();
                $opsi->opsi = $request->edit_opsi2;
                $opsi->id_soal_alumni = $detail_soal->id_detail_soal_alumni;
                $opsi->save();
            }

            if($request->edit_opsi3 != ""){
                $opsi = new tb_opsi_bank_soal_alumni();
                $opsi->opsi = $request->edit_opsi3;
                $opsi->id_soal_alumni = $detail_soal->id_detail_soal_alumni;
                $opsi->save();
            }

            if($request->edit_opsi4 != ""){
                $opsi = new tb_opsi_bank_soal_alumni();
                $opsi->opsi = $request->edit_opsi4;
                $opsi->id_soal_alumni = $detail_soal->id_detail_soal_alumni;
                $opsi->save();
            }

            if($request->edit_opsi5 != ""){
                $opsi = new tb_opsi_bank_soal_alumni();
                $opsi->opsi = $request->edit_opsi5;
                $opsi->id_soal_alumni = $detail_soal->id_detail_soal_alumni;
                $opsi->save();
            }
            if($request->edit_opsi6 != ""){
                $opsi = new tb_opsi_bank_soal_alumni();
                $opsi->opsi = $request->edit_opsi6;
                $opsi->id_soal_alumni = $detail_soal->id_detail_soal_alumni;
                $opsi->save();
            }
            if($request->edit_opsi7 != ""){
                $opsi = new tb_opsi_bank_soal_alumni();
                $opsi->opsi = $request->edit_opsi7;
                $opsi->id_soal_alumni = $detail_soal->id_detail_soal_alumni;
                $opsi->save();
            }
            if($request->edit_opsi8 != ""){
                $opsi = new tb_opsi_bank_soal_alumni();
                $opsi->opsi = $request->edit_opsi8;
                $opsi->id_soal_alumni = $detail_soal->id_detail_soal_alumni;
                $opsi->save();
            }
            if($request->edit_opsi9 != ""){
                $opsi = new tb_opsi_bank_soal_alumni();
                $opsi->opsi = $request->edit_opsi9;
                $opsi->id_soal_alumni = $detail_soal->id_detail_soal_alumni;
                $opsi->save();
            }
            if($request->edit_opsi10 != ""){
                $opsi = new tb_opsi_bank_soal_alumni();
                $opsi->opsi = $request->edit_opsi10;
                $opsi->id_soal_alumni = $detail_soal ->id_detail_soal_alumni;
                $opsi->save();
            }
        }

        return redirect()->route('show-banksoalalumni', $request->id_soal_alumni)->with('statusInput', 'Pertanyaan berhasil diperbaharui');
    }

    public function delete($id)
    {
        $detail_soal = tb_detail_soal_alumni::find($id);
        $detail_soal->delete();

        $opsis = tb_opsi_bank_soal_alumni::get();
        foreach($opsis as $opsi){
            if($opsi->id_detail_soal == $id){
                $opsi->delete();
            }
        }
        return back()->with('statusInput', 'Pertanyaan berhasil dihapus');
    }

    

}
