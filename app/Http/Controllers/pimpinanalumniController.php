<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\tb_alumni;
use App\tb_angkatan;
use App\tb_prodi;
use App\tb_periodealumni;
use App\tb_tahun_periode;
use App\tb_periode;
use Illuminate\Support\Facades\Validator;

use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
class pimpinanalumniController extends Controller
{

    public function periode(){
        $periodealumni = tb_periodealumni::orderby('id_tahun_periode','asc')->orderby('id_periode','asc')->get();
        $tahun = tb_tahun_periode::orderby('tahun_periode','asc')->get();
        $periode = tb_periode::orderby('periode','asc')->get();
        return view ('/pimpinan/alumni/alumniperiode',compact('periodealumni','tahun','periode'));
    }

    public function show($id){

        $periodes = tb_periodealumni::where('id_periode_alumni', $id)->first();
        $tahun_lulus = tb_tahun_periode::where('id_tahun_periode', $periodes->id_tahun_periode)->first()->tahun_periode;
        $periodealumni = tb_periode::where('id_periode', $periodes->id_periode)->first()->periode;

        $periode = tb_periodealumni::find($id);
        $alumni = tb_alumni::where('id_periode',$id)->with('relasiAlumnitoAngkatan','relasiAlumnitoProdi')->get();
        $id_periode = $id;
        $prodi = tb_prodi::get();
        $angkatan = tb_angkatan::orderBy('tahun_angkatan','asc')->get();
        $id_periode_alumni = $id;
        $status = ['Tolak','Konfirmasi','Menunggu Konfirmasi'];
  
            return view('/pimpinan/alumni/dataalumni', compact ('id_periode_alumni','alumni','prodi','angkatan','tahun_lulus','periodealumni'), ['alumni'=>$alumni]);
        }

}
