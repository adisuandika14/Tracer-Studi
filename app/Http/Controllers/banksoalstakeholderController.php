<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\tb_soal_stakeholder;
use App\tb_opsi_stakeholder;
use App\tb_jenis_kuesioner;


class banksoalstakeholderController extends Controller
{
    public function show()
    {
        $soal = tb_soal_stakeholder::get();
        $opsi = tb_opsi_stakeholder::get();

        return view('/BankSoal/banksoalstakeholder', compact('soal','opsi',));
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
            $bank_soal->pertanyaan = $request->pertanyaan;
            $bank_soal->save();
        }

        if($request->id_jenis ==  4){
            $bank_soal->id_jenis = 4;
            $bank_soal->pertanyaan = $request->pertanyaan;
            $bank_soal->save();
        }

        if($request->id_jenis == 1 || $request->id_jenis == 3){
            $bank_soal->id_jenis = $request->id_jenis;
            $bank_soal->pertanyaan = $request->pertanyaan;
            $bank_soal->save();

            $bank_soal = tb_soal_stakeholder::find(tb_soal_stakeholder::max('id_bank_soal'));
            if($request->opsi1 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->opsi1;
                $opsi->id_bank_soal = $bank_soal->id_bank_soal;
                $opsi->save();
            }

            if($request->opsi2 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->opsi2;
                $opsi->id_bank_soal = $bank_soal->id_bank_soal;
                $opsi->save();
            }

            if($request->opsi3 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->opsi3;
                $opsi->id_bank_soal = $bank_soal->id_bank_soal;
                $opsi->save();
            }

            if($request->opsi4 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->opsi4;
                $opsi->id_bank_soal = $bank_soal->id_bank_soal;
                $opsi->save();
            }

            if($request->opsi5 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->opsi5;
                $opsi->id_bank_soal = $bank_soal->id_bank_soal;
                $opsi->save();
            }
            if($request->opsi6 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->opsi6;
                $opsi->id_bank_soal = $bank_soal->id_bank_soal;
                $opsi->save();
            }
            if($request->opsi7 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->opsi7;
                $opsi->id_bank_soal = $bank_soal->id_bank_soal;
                $opsi->save();
            }
            if($request->opsi8 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->opsi8;
                $opsi->id_bank_soal = $bank_soal->id_bank_soal;
                $opsi->save();
            }
            if($request->opsi9 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->opsi9;
                $opsi->id_bank_soal = $bank_soal->id_bank_soal;
                $opsi->save();
            }
            if($request->opsi10 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->opsi10;
                $opsi->id_bank_soal = $bank_soal->id_bank_soal;
                $opsi->save();
            }
        }

        return redirect()->route('show-banksoal-stakeholder')->with('statusInput', 'Pertanyaan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $bank_soal = tb_soal_stakeholder::find($id);
        $opsis = tb_opsi_stakeholder::where('id_soal_stakeholder', $bank_soal->id_soal_stakeholder)->get();
        return response()->json(['success' => 'Berhasil', 'bank_soal' => $bank_soal, 'opsis' => $opsis]);
    }

    public function delete($id)
    {
        $detail_kuesioner = tb_soal_stakeholder::find($id);
        $detail_kuesioner->delete();

        $opsis = tb_opsi_stakeholder::get();
        foreach($opsis as $opsi){
            if($opsi->id_bank_soal == $id){
                $opsi->delete();
            }
        }
        return back()->with('statusInput', 'Pertanyaan berhasil dihapus');
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

        $opsis = tb_opsi_stakeholder::get();
        foreach($opsis as $opsi){
            if($opsi->id_bank_soal == $id){
                $opsi->delete();
            }
        }

        if($request->edit_id_jenis ==  2){
            $bank_soal->id_jenis = 2;
            $bank_soal->pertanyaan = $request->edit_pertanyaan;
            $bank_soal->update();
        }

        if($request->edit_id_jenis == 1 || $request->edit_id_jenis == 3){
            $bank_soal->id_jenis = 1;
            $bank_soal->pertanyaan = $request->edit_pertanyaan;
            $bank_soal->update();

            if($request->edit_opsi1 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->edit_opsi1;
                $opsi->id_bank_soal = $bank_soal->id_bank_soal;
                $opsi->save();
            }

            if($request->edit_opsi2 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->edit_opsi2;
                $opsi->id_bank_soal = $bank_soal->id_bank_soal;
                $opsi->save();
            }

            if($request->edit_opsi3 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->edit_opsi3;
                $opsi->id_bank_soal = $bank_soal->id_bank_soal;
                $opsi->save();
            }

            if($request->edit_opsi4 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->edit_opsi4;
                $opsi->id_bank_soal = $bank_soal->id_bank_soal;
                $opsi->save();
            }

            if($request->edit_opsi5 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->edit_opsi5;
                $opsi->id_bank_soal = $bank_soal->id_bank_soal;
                $opsi->save();
            }
            if($request->edit_opsi6 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->edit_opsi6;
                $opsi->id_bank_soal = $bank_soal->id_bank_soal;
                $opsi->save();
            }
            if($request->edit_opsi7 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->edit_opsi7;
                $opsi->id_bank_soal = $bank_soal->id_bank_soal;
                $opsi->save();
            }
            if($request->edit_opsi8 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->edit_opsi8;
                $opsi->id_bank_soal = $bank_soal->id_bank_soal;
                $opsi->save();
            }
            if($request->edit_opsi9 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->edit_opsi9;
                $opsi->id_bank_soal = $bank_soal->id_bank_soal;
                $opsi->save();
            }
            if($request->edit_opsi10 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->edit_opsi10;
                $opsi->id_bank_soal = $bank_soal->id_bank_soal;
                $opsi->save();
            }
        }

        return redirect()->route('show-banksoal-stakeholder', $request->id_kuesioner)->with('statusInput', 'Pertanyaan berhasil diperbaharui');
    }
}
