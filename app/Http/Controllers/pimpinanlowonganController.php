<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tb_lowongan;

class pimpinanlowonganController extends Controller
{
    public function show(){
        $lowongan = tb_lowongan::all();

        return view ('/pimpinan/lowongan/lowongan', compact('lowongan'));
    }

    public function detail($id)
    {
        $post = tb_lowongan::where('id_lowongan', $id)->first();
        return view('/pimpinan/lowongan/showlowongan', compact('post'));
    }
}
