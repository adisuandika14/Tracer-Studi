<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\facades\DB;
use App\tb_alumni;
use App\tb_pengumuman;
use App\tb_lowongan;
use App\tb_jawaban;
use App\tb_angkatan;

class dashboardpimpinanController extends Controller
{
    
    public function dashboard(){

        $alumnis = tb_alumni::count('id_alumni');
        $jawaban = tb_jawaban::count('id_jawaban');
        $pengumuman = tb_pengumuman::count('id_pengumuman');
        $lowongan = tb_lowongan::count('id_lowongan');
        $angkatan = tb_angkatan::orderBy('tahun_angkatan','asc')->get();
        // dd($angkatan);
        $tahun = [];
        $alumnitot = [] ;

        $angkatan = tb_angkatan::orderBy('tahun_angkatan','asc')->get();
        foreach($angkatan as $ang){
            $alumni = tb_alumni::where('id_angkatan', $ang->id_angkatan)->count('id_alumni', 'tahun');
            // dd($ang->tahun_angkatan." ".$alumni);
            $alumnitot[] = $alumni;
            $tahun[] = $ang->tahun_angkatan;
        }
    	return view("pimpinan/dashboard", compact('alumnis','jawaban','pengumuman','lowongan','tahun','alumnitot'));
    }
}
