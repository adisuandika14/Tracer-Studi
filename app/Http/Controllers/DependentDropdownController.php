<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\Regency;
use App\tb_kota;
use App\tb_provinsi;
use Illuminate\Http\Request;

class DependentDropdownController extends Controller
{
    public function index()
    {
        $provinces = Province::pluck('name', 'province_id');

        return view('alumni/dataalumni', [
            'provinces' => $provinces,
        ]);
    }

    public function store(Request $request)
    {
        $cities = Regency::where('province_id', $request->get('id'))
            ->pluck('name', 'regencies_id');
    
        return response()->json($cities);
    }

}
