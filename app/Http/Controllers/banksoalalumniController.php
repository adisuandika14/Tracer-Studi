<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\tb_soal_alumni;
use App\tb_prodi;
use App\tb_kuesioner;
use App\tb_opsi_bank_soal_alumni;

class banksoalalumniController extends Controller
{
    public function show(){

        $bank_soal = tb_soal_alumni::get();
        $prodi = tb_prodi::all();
        //$kuesioner = tb_kuesioner::all();
        // $alumni = tb_alumni::all();
        // $master_kuesioner = tb_master_kuesioner::all();
        $opsi = tb_opsi_bank_soal_alumni::all();
            return view('/BankSoal/banksoalalumni', compact ('bank_soal','prodi','opsi'));
        }

        public function create(Request $request){
            $validator = Validator::make($request->all(), [
                'pertanyaan' => 'required',
            ],[
                 'pertanyaan.required' => "Anda Belum Menambahkan Kuesioner",
             ]);
    
            if($validator->fails()){
                return back()->withErrors($validator);
            }
    
            $bank_soal = new tb_soal_alumni();
            $bank_soal->pertanyaan = $request->pertanyaan;
            $bank_soal->save();
    
            return redirect('/admin/banksoal/alumni')->with('statusInput','Data berhasil disimpan!');
        }
    
        public function delete($id){
            $delete = tb_soal_alumni::find($id);
            $delete->delete();
            return redirect ('/admin/banksoal/alumni')->with('statusInput','Data berhasil dihapus!'); 
        }

        public function update(Request $request){
            $validator = Validator::make($request->all(), [
                'pertanyaan' => 'required',
            ],[
                 'pertanyaan.required' => "Anda Belum Menambahkan Kuesioner",
             ]);

            if($validator->fails()){
                return back()->withErrors($validator);
            }
            $res = NULL;
            $bank_soal = tb_soal_alumni::find($request->id_soal_alumni);
            $bank_soal->pertanyaan = $request->pertanyaan;
            $bank_soal->update();
           return redirect('/admin/banksoal/alumni')->with('statusInput','Data berhasil diupdate!');
        }

        
}
