<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tb_pengumuman;

class pimpinanpengumumanController extends Controller
{
    public function show(){
        $pengumuman = tb_pengumuman::all();
        //dd($pengumuman);
        return view ('/pimpinan/pengumuman/pengumuman', compact('pengumuman'));
    }

    public function detail($id)
    {
        $post = tb_pengumuman::where('id_pengumuman', $id)->first();
        //dd($post);
        return view('/pimpinan/pengumuman/showpengumuman', compact('post'));
    }


}
