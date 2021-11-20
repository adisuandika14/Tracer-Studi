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
    public function index(){
        $id_tahun_periode = tb_tahun_periode::max('id_tahun_periode');
        $periodess = tb_tahun_periode::get();
        $prodi = tb_prodi::get();

        return view('kuesioner/stakeholder/kuesionerstakeholder', compact('id_tahun_periode','periodess','prodi'));
    }

    public function detail_kuesioner($id_prodi, $id_periode){
        $detail = tb_kuesioner_stakeholder::where('id_prodi', $id_prodi)->where('id_tahun_periode', $id_periode)->orderBy('created_at','asc')->get();
        $id_kuesioner_stakeholder = $detail;
        
        $opsi = tb_opsi_stakeholder::get();
        $tahun = tb_tahun_periode::find($id_periode)->tahun_periode;
        $prodi = tb_prodi::find($id_prodi)->nama_prodi;
        return view('kuesioner/stakeholder/showkuesioner', compact('detail', 'id_prodi', 'id_periode', 'opsi','tahun','prodi','id_kuesioner_stakeholder'));
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

    // public function edit($id)
    // {
    //     $kuesioner_stakeholder = tb_kuesioner_stakeholder::find($id);
    //     $opsis = tb_opsi_stakeholder::where('id_soal_pengguna', $kuesioner_stakeholder->id_kuesioner_stakeholder)->get();
    //     return response()->json(['success' => 'Berhasil', 'detail_kuesioner' => $kuesioner_stakeholder, 'opsis' => $opsis]);
    // }

    public function edit($id)
    {
        $kuesioner_stakeholder = tb_kuesioner_stakeholder::find($id);
        $opsis = tb_opsi_stakeholder::where('id_soal_pengguna', $kuesioner_stakeholder->id_kuesioner_stakeholder)->get();
        return response()->json(['success' => 'Berhasil', 'kuesioner_stakeholder' => $kuesioner_stakeholder, 'opsis' => $opsis]);
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
            if($opsi->id_soal_pengguna == $id){
                $opsi->delete();
            }
        }

        if($request->edit_id_jenis ==  2){
            $kuesioner_stakeholder->id_kuesioner_stakeholder = $request->id_kuesioner_stakeholder;
            $kuesioner_stakeholder->id_jenis = 2;
            
            $kuesioner_stakeholder->pertanyaan = $request->edit_pertanyaan;
            $kuesioner_stakeholder->status = "Menunggu Konfirmasi";
            $kuesioner_stakeholder->update();
        }
        if($request->edit_id_jenis ==  4){
            $kuesioner_stakeholder->id_kuesioner_stakeholder = $request->id_kuesioner_stakeholder;
            $kuesioner_stakeholder->id_jenis = 4;
            
            $kuesioner_stakeholder->pertanyaan = $request->edit_pertanyaan;
            $kuesioner_stakeholder->status = "Menunggu Konfirmasi";
            $kuesioner_stakeholder->update();
        }

        if($request->edit_id_jenis == 1 || $request->edit_id_jenis == 3){
            $kuesioner_stakeholder->id_kuesioner_stakeholder = $request->id_kuesioner_stakeholder;
            $kuesioner_stakeholder->id_jenis = 1;
            
            $kuesioner_stakeholder->pertanyaan = $request->edit_pertanyaan;
            $kuesioner_stakeholder->status = "Menunggu Konfirmasi";
            $kuesioner_stakeholder->update();

            if($request->edit_opsi1 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->edit_opsi1;
                $opsi->id_soal_pengguna = $kuesioner_stakeholder->id_kuesioner_stakeholder;
                $opsi->save();
            }

            if($request->edit_opsi2 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->edit_opsi2;
                $opsi->id_soal_pengguna = $kuesioner_stakeholder->id_kuesioner_stakeholder;
                $opsi->save();
            }

            if($request->edit_opsi3 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->edit_opsi3;
                $opsi->id_soal_pengguna = $kuesioner_stakeholder->id_kuesioner_stakeholder;
                $opsi->save();
            }

            if($request->edit_opsi4 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->edit_opsi4;
                $opsi->id_soal_pengguna = $kuesioner_stakeholder->id_kuesioner_stakeholder;
                $opsi->save();
            }

            if($request->edit_opsi5 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->edit_opsi5;
                $opsi->id_soal_pengguna = $kuesioner_stakeholder->id_kuesioner_stakeholder;
                $opsi->save();
            }
            if($request->edit_opsi6 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->edit_opsi6;
                $opsi->id_soal_pengguna = $kuesioner_stakeholder->id_kuesioner_stakeholder;
                $opsi->save();
            }
            if($request->edit_opsi7 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->edit_opsi7;
                $opsi->id_soal_pengguna = $kuesioner_stakeholder->id_kuesioner_stakeholder;
                $opsi->save();
            }
            if($request->edit_opsi8 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->edit_opsi8;
                $opsi->id_soal_pengguna = $kuesioner_stakeholder->id_kuesioner_stakeholder;
                $opsi->save();
            }
            if($request->edit_opsi9 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->edit_opsi9;
                $opsi->id_soal_pengguna = $kuesioner_stakeholder->id_kuesioner_stakeholder;
                $opsi->save();
            }
            if($request->edit_opsi10 != ""){
                $opsi = new tb_opsi_stakeholder();
                $opsi->opsi = $request->edit_opsi10;
                $opsi->id_soal_pengguna = $kuesioner_stakeholder->id_kuesioner_stakeholder;
                $opsi->save();
            }
        }

        return back()->with('statusInput', 'Pertanyaan berhasil diperbaharui');
    }

    public function delete($id)
    {
        $detail_kuesioner = tb_kuesioner_stakeholder::find($id);
        $detail_kuesioner->delete();

        $opsis = tb_opsi_stakeholder::get();
        foreach($opsis as $opsi){
            if($opsi->id_soal_penggguna == $id){
                $opsi->delete();
            }
        }
        return back()->with('statusInput', 'Pertanyaan berhasil dihapus');
    }


    public function filter(Request $request)
    {
        $detail = tb_prodi::get();
        $hasil = view('kuesioner.stakeholder.filterkuesioner', ['detail' => $detail])->render();
        // $hasil = $kategori;
        return response()->json(['success' => 'Produk difilter', 'hasil' => $hasil]);
    }
}
