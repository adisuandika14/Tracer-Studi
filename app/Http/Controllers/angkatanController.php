<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\tb_angkatan;

class angkatanController extends Controller
{
    public function show(){
        $angkatan = tb_angkatan::orderBy('tahun_angkatan','asc')->get();
            return view('/admin/masterangkatan', compact ('angkatan'));
        }
    
        public function create(Request $request){
                tb_angkatan::create([
                    'tahun_angkatan'=>$request->tahun_angkatan,
                    ]);
                return redirect('/admin/angkatan')->with('success','Data berhasil disimpan!');
    
        }
    
        public function delete($id){
            $deletedata = tb_angkatan::find($id);
            $deletedata->delete();
            return redirect('/admin/angkatan')->with('success','Data berhasil dihapus!');
        }

        public function update(Request $request){
            $res = NULL;
            $updatedata = tb_angkatan::find($request->id_angkatan);
            $updatedata->tahun_angkatan = $request->tahun_angkatan;
            $updatedata->update();
            //dd($updatedata);
           return redirect('/admin/angkatan')->with('success','Data berhasil diupdate!');
        }
    
}
