<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\AlumniExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Chart;
use App\tb_alumni;
use App\tb_angkatan;
use Carbon\Carbon;

class dashboardController extends Controller
{
    public function dashboard(){
        // $alumni = DB::table('tb_alumni')->count('id_alumni');
        $jawaban = DB::table('tb_jawaban')->count('id_jawaban');
        $pengumuman = DB::table('tb_pengumuman')->count('id_pengumuman');
        $lowongan = DB::table('tb_lowongan')->count('id_lowongan');
        $angkatan = tb_angkatan::all();
        // dd($angkatan);
        $tahun = [];
        $alumnitot = [] ;

        foreach($angkatan as $ang){
            $alumni = tb_alumni::where('id_angkatan', $ang->id_angkatan)->count('id_alumni', 'tahun');
            // dd($ang->tahun_angkatan." ".$alumni);
            $alumnitot[] = $alumni;
            $tahun[] = $ang->tahun_angkatan;
        }
        
        return view('admin/dashboard ', compact('alumni','jawaban','pengumuman','lowongan', 'alumnitot', 'tahun') );
    }


    // public function export(){
    //     return Excel::download(new ALumniExport, 'Data Alumni.xlsx');
    // }

    public function chartjs()
    {
        $alumni = DB::table('tb_alumni')->count('id_alumni');
        $jawaban = DB::table('tb_jawaban')->count('id_jawaban');
        $pengumuman = DB::table('tb_pengumuman')->count('id_pengumuman');
        $lowongan = DB::table('tb_lowongan')->count('id_lowongan');
        $angkatan = tb_angkatan::get();
        
        $groups = DB::table('tb_alumni')
                        ->select('id_alumni', DB::raw('count(*) as total'))
                        ->groupBy('id_angkatan->tahun_angkatan')
                        ->pluck('total', 'id_alumni')->all();
        // Generate random colours for the groups
        for ($i=0; $i<=count($groups); $i++) {
                    $colours[] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
                }
        
        // Prepare the data for returning with the view
        $chart = new Chart;
                $chart->labels = (array_keys($groups));
                $chart->dataset = (array_values($groups));
                $chart->colours = $colours;
        return view('/admin/dashboard', compact('chart','alumni','jawaban','pengumuman','lowongan'));
    }
}