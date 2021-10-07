<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\facades\DB;

class dashboardpimpinanController extends Controller
{
    
    public function dashboard(){
        $alumni = DB::table('tb_alumni')->count('id_alumni');
        $kuesioner = DB::table('tb_kuesioner')->count('id_kuesioner');
        $pengumuman = DB::table('tb_pengumuman')->count('id_pengumuman');
        $lowongan = DB::table('tb_lowongan')->count('id_lowongan');
        
    	return view("pimpinan/dashboard", compact('alumni','kuesioner','pengumuman','lowongan'));
    }
}
