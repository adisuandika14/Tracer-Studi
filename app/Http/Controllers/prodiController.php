<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tb_prodi;

class prodiController extends Controller
{
    public function show(){
        $prodi = tb_prodi::all();
            return view('/admin/masterprodi', compact ('prodi'));
        }
    
        public function create(Request $request){
                tb_prodi::create([
                    'nama_prodi'=>$request->nama_prodi,
                    ]);
                return redirect('/admin/prodi')->with('success','Data berhasil disimpan!');
    
        }
    
        public function delete($id){
            $deletedata = tb_prodi::find($id);
            $deletedata->delete();
            return redirect('/admin/prodi')->with('success','Data berhasil dihapus!');
        }

        public function update(Request $request){
            $res = NULL;
            $updatedata = tb_prodi::find($request->id_prodi);
            $updatedata->nama_prodi = $request->nama_prodi;
            $updatedata->update();
            //dd($updatedata);
           return redirect('/admin/prodi')->with('success','Data berhasil diupdate!');
        }
}
