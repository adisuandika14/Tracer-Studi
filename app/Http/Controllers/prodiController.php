<?php

namespace App\Http\Controllers;

use App\tb_periode;
use Illuminate\Http\Request;
use App\tb_prodi;
use Illuminate\Support\Facades\Validator;

class prodiController extends Controller
{
    public function show(){
        $prodi = tb_prodi::get();
            return view('/admin/masterprodi', compact ('prodi'));
        }
    
        public function create(Request $request){

            $cek_prodi = tb_prodi::where('nama_prodi', $request->nama_prodi)->first();
            if($cek_prodi != ''){
                return back()->with('error', 'Data yang dimasukkan sudah terdaftar');
            }

            $nama_prodi = new tb_prodi();
            $nama_prodi->nama_prodi = $request->nama_prodi;
            $nama_prodi->save();
            
            return redirect('/admin/prodi')->with('success','Data berhasil diupdate!');
        }
    
        public function delete($id){
            $deletedata = tb_prodi::find($id);
            $deletedata->delete();
            return redirect('/admin/prodi')->with('success','Data berhasil dihapus!');
        }

        public function update(Request $request){
            $res = NULL;
            $cek_prodi = tb_prodi::where('nama_prodi', $request->nama_prodi)->first();
            if($cek_prodi != ''){
                return back()->with('error', 'Data yang dimasukkan sudah terdaftar');
            }

            
            $updatedata = tb_prodi::find($request->id_prodi);
            $updatedata->nama_prodi = $request->nama_prodi;
            $updatedata->update();
            //dd($updatedata);
           return redirect('/admin/prodi')->with('success','Data berhasil diupdate!');
        }
}
