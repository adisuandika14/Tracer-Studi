<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\tb_kuesioner;
use App\tb_jenis_kuesioner;
use App\tb_opsi;
use App\tb_detail_kuesioner;

class pertanyaanController extends Controller
{ 
    public function show(){
        
        $pertanyaan = tb_detail_kuesioner::all();
        $kuesioner = tb_kuesioner::all();
        $jenis = tb_jenis_kuesioner::all();
        $opsi = tb_opsi::all();
            return view('/kuesioner/masterkuesioner', compact ('pertanyaan','kuesioner','opsi','jenis'));
        }

        public function delete($id){
            $delete_data = tb_detail_kuesioner::find($id);
            $delete_data->delete();
            return back()->with('statusInpput','Pertanyaan Berhasil dihapus');
        }
    
    
        // public function delete($id){
        //     $deletedata = tb_kuesioner::find($id);
        //     $deletedata->delete();
        //     return redirect('/admin/pertanyaan')->with('success','Data berhasil dihapus!');
        // }

        // public function delete($id)
        // {
        //     $detail_kuesioner = tb_detail_kuesioner::find($id);
        //     $detail_kuesioner->delete();
    
        //     $opsis = tb_opsi::get();
        //     foreach($opsis as $opsi){
        //         if($opsi->id_detail_kuesioner == $id){
        //             $opsi->delete();
        //         }
        //     }
        //     return back()->with('statusInput', 'Pertanyaan berhasil dihapus');
        // }

        public function create(Request $request){
            $validator = Validator::make($request->all(), [
                'id_jenis' => 'required',
                'pertanyaan' => 'required',
            ]);
    
            if($validator->fails()){
                return back()->withErrors($validator);
            }
    
            $detail_kuesioner = new tb_detail_kuesioner();
    
            if($request->id_jenis ==  2){
                $detail_kuesioner->id_kuesioner = $request->id_kuesioner;
                $detail_kuesioner->id_jenis = 2;
                $detail_kuesioner->pertanyaan = $request->pertanyaan;
                $detail_kuesioner->status = "Menunggu Konfirmasi";
                $detail_kuesioner->save();
            }
    
            if($request->id_jenis == 1){
                $detail_kuesioner->id_kuesioner = $request->id_kuesioner;
                $detail_kuesioner->id_jenis = 1;
                $detail_kuesioner->pertanyaan = $request->pertanyaan;
                $detail_kuesioner->status = "Menunggu Konfirmasi";
                $detail_kuesioner->save();
    
                $detail_kuesioner = tb_detail_kuesioner::find(tb_detail_kuesioner::max('id_detail_kuesioner'));
                if($request->opsi1 != ""){
                    $opsi = new tb_opsi();
                    $opsi->opsi = $request->opsi1;
                    $opsi->id_detail_kuesioner = $detail_kuesioner->id_detail_kuesioner;
                    $opsi->save();
                }
    
                if($request->opsi2 != ""){
                    $opsi = new tb_opsi();
                    $opsi->opsi = $request->opsi2;
                    $opsi->id_detail_kuesioner = $detail_kuesioner->id_detail_kuesioner;
                    $opsi->save();
                }
    
                if($request->opsi3 != ""){
                    $opsi = new tb_opsi();
                    $opsi->opsi = $request->opsi3;
                    $opsi->id_detail_kuesioner = $detail_kuesioner->id_detail_kuesioner;
                    $opsi->save();
                }
    
                if($request->opsi4 != ""){
                    $opsi = new tb_opsi();
                    $opsi->opsi = $request->opsi4;
                    $opsi->id_detail_kuesioner = $detail_kuesioner->id_detail_kuesioner;
                    $opsi->save();
                }
    
                if($request->opsi5 != ""){
                    $opsi = new tb_opsi();
                    $opsi->opsi = $request->opsi5;
                    $opsi->id_detail_kuesioner = $detail_kuesioner->id_detail_kuesioner;
                    $opsi->save();
                }
                if($request->opsi6 != ""){
                    $opsi = new tb_opsi();
                    $opsi->opsi = $request->opsi6;
                    $opsi->id_detail_kuesioner = $detail_kuesioner->id_detail_kuesioner;
                    $opsi->save();
                }
                if($request->opsi7 != ""){
                    $opsi = new tb_opsi();
                    $opsi->opsi = $request->opsi7;
                    $opsi->id_detail_kuesioner = $detail_kuesioner->id_detail_kuesioner;
                    $opsi->save();
                }
                if($request->opsi8 != ""){
                    $opsi = new tb_opsi();
                    $opsi->opsi = $request->opsi8;
                    $opsi->id_detail_kuesioner = $detail_kuesioner->id_detail_kuesioner;
                    $opsi->save();
                }
                if($request->opsi9 != ""){
                    $opsi = new tb_opsi();
                    $opsi->opsi = $request->opsi9;
                    $opsi->id_detail_kuesioner = $detail_kuesioner->id_detail_kuesioner;
                    $opsi->save();
                }
                if($request->opsi10 != ""){
                    $opsi = new tb_opsi();
                    $opsi->opsi = $request->opsi10;
                    $opsi->id_detail_kuesioner = $detail_kuesioner->id_detail_kuesioner;
                    $opsi->save();
                }
            }
    
            return redirect()->route('show-pertanyaan', $request->id_kuesioner)->with('statusInput', 'Pertanyaan berhasil ditambahkan');
        }

        public function edit($id)
        {
            $detail_kuesioner = tb_detail_kuesioner::find($id);
            $opsis = tb_opsi::where('id_detail_kuesioner', $detail_kuesioner->id_detail_kuesioner)->get();
            return response()->json(['success' => 'Berhasil', 'detail_kuesioner' => $detail_kuesioner, 'opsis' => $opsis]);
        }

        public function update($id, Request $request){
            $validator = Validator::make($request->all(), [
                'edit_id_jenis' => 'required',
                'edit_pertanyaan' => 'required',
            ]);
    
            if($validator->fails()){
                return back()->withErrors($validator);
            }
    
            
    
            $detail_kuesioner = tb_detail_kuesioner::find($id);
    
            $opsis = tb_opsi::get();
            foreach($opsis as $opsi){
                if($opsi->id_detail_kuesioner == $id){
                    $opsi->delete();
                }
            }
    
            if($request->edit_id_jenis ==  2){
                $detail_kuesioner->id_kuesioner = $request->id_kuesioner;
                $detail_kuesioner->id_jenis = 2;
                $detail_kuesioner->pertanyaan = $request->edit_pertanyaan;
                $detail_kuesioner->status = "Menunggu Konfirmasi";
                $detail_kuesioner->update();
            }
    
            if($request->edit_id_jenis == 1){
                $detail_kuesioner->id_kuesioner = $request->id_kuesioner;
                $detail_kuesioner->id_jenis = 1;
                $detail_kuesioner->pertanyaan = $request->edit_pertanyaan;
                $detail_kuesioner->status = "Menunggu Konfirmasi";
                $detail_kuesioner->update();
    
                if($request->edit_opsi1 != ""){
                    $opsi = new tb_opsi();
                    $opsi->opsi = $request->edit_opsi1;
                    $opsi->id_detail_kuesioner = $detail_kuesioner->id_detail_kuesioner;
                    $opsi->save();
                }
    
                if($request->edit_opsi2 != ""){
                    $opsi = new tb_opsi();
                    $opsi->opsi = $request->edit_opsi2;
                    $opsi->id_detail_kuesioner = $detail_kuesioner->id_detail_kuesioner;
                    $opsi->save();
                }
    
                if($request->edit_opsi3 != ""){
                    $opsi = new tb_opsi();
                    $opsi->opsi = $request->edit_opsi3;
                    $opsi->id_detail_kuesioner = $detail_kuesioner->id_detail_kuesioner;
                    $opsi->save();
                }
    
                if($request->edit_opsi4 != ""){
                    $opsi = new tb_opsi();
                    $opsi->opsi = $request->edit_opsi4;
                    $opsi->id_detail_kuesioner = $detail_kuesioner->id_detail_kuesioner;
                    $opsi->save();
                }
    
                if($request->edit_opsi5 != ""){
                    $opsi = new tb_opsi();
                    $opsi->opsi = $request->edit_opsi5;
                    $opsi->id_detail_kuesioner = $detail_kuesioner->id_detail_kuesioner;
                    $opsi->save();
                }
                if($request->edit_opsi6 != ""){
                    $opsi = new tb_opsi();
                    $opsi->opsi = $request->edit_opsi6;
                    $opsi->id_detail_kuesioner = $detail_kuesioner->id_detail_kuesioner;
                    $opsi->save();
                }
                if($request->edit_opsi7 != ""){
                    $opsi = new tb_opsi();
                    $opsi->opsi = $request->edit_opsi7;
                    $opsi->id_detail_kuesioner = $detail_kuesioner->id_detail_kuesioner;
                    $opsi->save();
                }
                if($request->edit_opsi8 != ""){
                    $opsi = new tb_opsi();
                    $opsi->opsi = $request->edit_opsi8;
                    $opsi->id_detail_kuesioner = $detail_kuesioner->id_detail_kuesioner;
                    $opsi->save();
                }
                if($request->edit_opsi9 != ""){
                    $opsi = new tb_opsi();
                    $opsi->opsi = $request->edit_opsi9;
                    $opsi->id_detail_kuesioner = $detail_kuesioner->id_detail_kuesioner;
                    $opsi->save();
                }
                if($request->edit_opsi10 != ""){
                    $opsi = new tb_opsi();
                    $opsi->opsi = $request->edit_opsi10;
                    $opsi->id_detail_kuesioner = $detail_kuesioner->id_detail_kuesioner;
                    $opsi->save();
                }
            }
    
            return redirect()->route('show-pertanyaan', $request->id_kuesioner)->with('statusInput', 'Pertanyaan berhasil diperbaharui');
        }
}