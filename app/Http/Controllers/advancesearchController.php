<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\tb_jawaban;
use App\tb_prodi;
use App\tb_alumni;

class advancesearchController extends Controller
{
	public function advance(Request $request)
	{
		$data = DB::table('tb_jawaban');
		if( $request->prodi)
        {
			$data = $data->where('id_prodi', 'LIKE', "%" . $request->nama_prodi . "%");
		}
		if( $request->angkatan)
        {
			$data = $data->where('id_angkatan', 'LIKE', "%" . $request->tahun_ankatan . "%");
		}
		$data = $data->paginate(10);
		return view('/kuesioner/tracer', compact('data'));
	}
}