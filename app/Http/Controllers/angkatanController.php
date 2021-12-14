<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\tb_angkatan;
use Illuminate\Support\Facades\Validator;

class angkatanController extends Controller
{
    public function show(){
        $angkatan = tb_angkatan::orderBy('tahun_angkatan','asc')->where('deleted_at',NULL)->get();
            return view('/admin/masterangkatan', compact ('angkatan'));
        }
    
        public function create(Request $request){
            $validator = Validator::make($request->all(), [
                'tahun_angkatan' => "required|min:3",

            ],[
                 'tahun_angkatan.required' => "Anda Belum Menambahkan Tahun Periode",
                 'tahun_angkatan.unique' => "Tahun yang dimasukkan sudah Terdaftar",
             ]);
    
            if($validator->fails()){
                return back()->withErrors($validator);
            }

                tb_angkatan::create([
                    'tahun_angkatan'=>$request->tahun_angkatan,
                    ]);
                return redirect('/admin/angkatan')->with('sukses','Data berhasil ditambahkan!');
    
        }
    
        public function delete($id){
            $deletedata = tb_angkatan::find($id);
            $deletedata->delete();
            return redirect('/admin/angkatan')->with('sukses','Data berhasil dihapus!');
        }

        public function update(Request $request){
            $validator = Validator::make($request->all(), [
                'tahun_angkatan' => 'required|unique:tb_angkatan,tahun_angkatan',
            ],[
                 'tahun_angkatan.required' => "Anda Belum Menambahkan Tahun Periode",
                 'tahun_angkatan.unique' => "Tahun yang dimasukkan sudah Terdaftar",
             ]);
    
            if($validator->fails()){
                return back()->withErrors($validator);
            }
            
            $res = NULL;
            $updatedata = tb_angkatan::find($request->id_angkatan);
            $updatedata->tahun_angkatan = $request->tahun_angkatan;
            $updatedata->update();
            //dd($updatedata);
           return redirect('/admin/angkatan')->with('sukses','Data berhasil diperbaharui!');
        }
    
}
