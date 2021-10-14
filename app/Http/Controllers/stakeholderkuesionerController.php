<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\tb_tahun_periode;
use App\tb_prodi;
use App\tb_kuesioner_stakeholder;
use App\tb_opsi_stakeholder;
use App\tb_opsi_soal_stakeholder;
use App\tb_soal_stakeholder;

class stakeholderkuesionerController extends Controller
{
    public function show(){
        $id_tahun_periode = tb_tahun_periode::max('id_tahun_periode');
        $periode = tb_tahun_periode::get();
        $prodi = tb_prodi::get();

        return view('kuesioner/stakeholder/kuesionerstakeholder', compact('id_tahun_periode','periode','prodi'));
    }

    public function detail_kuesioner($id_prodi, $id_periode){
        $detail = tb_kuesioner_stakeholder::where('id_prodi', $id_prodi)->where('id_tahun_periode', $id_periode)->get();
        $opsi =tb_opsi_stakeholder::get();
        return view('kuesioner/stakeholder/showkuesioner', compact('detail', 'id_prodi', 'id_periode', 'opsi'));
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'id_jenis' => 'required', 
            'pertanyaan' => 'required',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator);
        }

        $detail_kuesioner = new tb_kuesioner_stakeholder();

        if($request->id_jenis ==  2){
            $detail_kuesioner->id_kuesioner_stakeholder = $request->id_kuesioner;
            $detail_kuesioner->id_jenis = 2;
            $detail_kuesioner->id_prodi = $request->id_prodi;
            $detail_kuesioner->id_tahun_periode = $request->id_tahun_periode;
            $detail_kuesioner->pertanyaan = $request->pertanyaan;
            $detail_kuesioner->save();
        }

        if($request->id_jenis ==  4){
            $detail_kuesioner->id_kuesioner_stakeholder = $request->id_kuesioner;
            $detail_kuesioner->id_jenis = 4;
            $detail_kuesioner->id_prodi = $request->id_prodi;
            $detail_kuesioner->id_tahun_periode = $request->id_tahun_periode;
            $detail_kuesioner->pertanyaan = $request->pertanyaan;
            $detail_kuesioner->save();
        }

        if($request->id_jenis == 1 || $request->id_jenis == 3){
            $detail_kuesioner->id_kuesioner_stakeholder = $request->id_kuesioner;
            $detail_kuesioner->id_jenis = $request->id_jenis;
            $detail_kuesioner->id_prodi = $request->id_prodi;
            $detail_kuesioner->id_tahun_periode = $request->id_tahun_periode;
            $detail_kuesioner->pertanyaan = $request->pertanyaan;
            $detail_kuesioner->save();

            $detail_kuesioner = tb_kuesioner_stakeholder::find(tb_kuesioner_stakeholder::max('id_kuesioner_stakeholder'));
            if($request->opsi1 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->opsi1;
                $opsi->id_soal_pengguna = $detail_kuesioner->id_kuesioner_stakeholder;
                $opsi->save();
            }

            if($request->opsi2 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->opsi2;
                $opsi->id_soal_pengguna = $detail_kuesioner->id_kuesioner_stakeholder;
                $opsi->save();
            }

            if($request->opsi3 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->opsi3;
                $opsi->id_soal_pengguna = $detail_kuesioner->id_kuesioner_stakeholder;
                $opsi->save();
            }

            if($request->opsi4 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->opsi4;
                $opsi->id_soal_pengguna = $detail_kuesioner->id_kuesioner_stakeholder;
                $opsi->save();
            }

            if($request->opsi5 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->opsi5;
                $opsi->id_soal_pengguna = $detail_kuesioner->id_kuesioner_stakeholder;
                $opsi->save();
            }
            if($request->opsi6 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->opsi6;
                $opsi->id_soal_pengguna = $detail_kuesioner->id_kuesioner_stakeholder;
                $opsi->save();
            }
            if($request->opsi7 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->opsi7;
                $opsi->id_soal_pengguna = $detail_kuesioner->id_kuesioner_stakeholder;
                $opsi->save();
            }
            if($request->opsi8 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->opsi8;
                $opsi->id_soal_pengguna = $detail_kuesioner->id_kuesioner_stakeholder;
                $opsi->save();
            }
            if($request->opsi9 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->opsi9;
                $opsi->id_soal_pengguna = $detail_kuesioner->id_kuesioner_stakeholder;
                $opsi->save();
            }
            if($request->opsi10 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->opsi10;
                $opsi->id_soal_pengguna = $detail_kuesioner->id_kuesioner_stakeholder;
                $opsi->save();
            }
        }

        return redirect('/admin/kuesioner/stakeholder/detail/'.$request->id_prodi.'/'.$request->id_tahun_periode)->with('statusInput', 'Pertanyaan berhasil ditambahkan');
    }

    public function bank_soal_data($id_prodi, $id_periode){
        $kuesioner = tb_kuesioner_stakeholder::where('id_prodi', $id_prodi)->where('id_tahun_periode', $id_periode)->pluck('id_bank_soal')->toArray();
        $bank_soal_kuesioner = tb_soal_stakeholder::whereNotIn('id_soal_stakeholder', array_filter($kuesioner))->get();
        return response()->json($bank_soal_kuesioner);
    }

    public function create_from_bank_soal($id_prodi, $id_periode, Request $request){
        $all_bank_soal = tb_soal_stakeholder::get();
        foreach($all_bank_soal as $bank_soal){
            if($request->{'bank_soal_' .$bank_soal->id_soal_stakeholder}  != ""){
                $detail_kuesioner = new tb_kuesioner_stakeholder();
                if($bank_soal->id_jenis ==  2){
                    $detail_kuesioner->id_jenis = $bank_soal->id_jenis;
                    $detail_kuesioner->id_prodi = $id_prodi;
                    $detail_kuesioner->id_tahun_periode = $id_periode;
                    $detail_kuesioner->id_bank_soal = $bank_soal->id_soal_stakeholder;
                    $detail_kuesioner->pertanyaan = $bank_soal->pertanyaan;
                    $detail_kuesioner->save();
                }
        
                if($bank_soal->id_jenis ==  4){
                    $detail_kuesioner->id_jenis = $bank_soal->id_jenis;
                    $detail_kuesioner->id_prodi = $id_prodi;
                    $detail_kuesioner->id_tahun_periode = $id_periode;
                    $detail_kuesioner->id_bank_soal = $bank_soal->id_soal_stakeholder;
                    $detail_kuesioner->pertanyaan = $bank_soal->pertanyaan;
                    $detail_kuesioner->save();
                }

                if($bank_soal->id_jenis == 1 || $bank_soal->id_jenis == 3){
                    $detail_kuesioner->id_jenis = $bank_soal->id_jenis;
                    $detail_kuesioner->id_prodi = $id_prodi;
                    $detail_kuesioner->id_tahun_periode = $id_periode;
                    $detail_kuesioner->id_bank_soal = $bank_soal->id_soal_stakeholder;
                    $detail_kuesioner->pertanyaan = $bank_soal->pertanyaan;
                    $detail_kuesioner->save();

                    $detail_kuesioner = tb_kuesioner_stakeholder::find(tb_kuesioner_stakeholder::max('id_kuesioner_stakeholder'));
                    $opsis = tb_opsi_soal_stakeholder::where('id_soal_stakeholder', $bank_soal->id_soal_stakeholder )->get();
                    foreach($opsis as $opsi){
                        $new_opsi = new tb_opsi_stakeholder();
                        $new_opsi->opsi = $opsi->opsi;
                        $new_opsi->id_soal_pengguna = $detail_kuesioner->id_kuesioner_stakeholder;
                        $new_opsi->save();
                    }
                }


            }
            
        }
        return redirect('/admin/kuesioner/stakeholder/detail/'.$id_prodi.'/'.$id_periode)->with('statusInput', 'Pertanyaan berhasil ditambahkan');
    }

    // public function filter(Request $request)
    // {
    //     $detail = tb_kuesioner_stakeholder::where('id_tahun_periode', $request->id_tahun_periode)->get();
    //     $hasil = view('kuesioner.stakeholder.filterkuesioner', ['detail' => $detail])->render();
    //     // $hasil = $kategori;
    //     return response()->json(['success' => 'Produk difilter', 'hasil' => $hasil]);
    // }
}
