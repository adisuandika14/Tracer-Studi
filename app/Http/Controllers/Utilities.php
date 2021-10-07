<?php

namespace App\Http\Controllers\KetuaLab;

use App\tb_angkatan;
use App\tb_alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Utilities
{
    

    public static function getAlumni($id){
        $alumnidata = tb_alumni::where('id_alumni',$id)->first();
        if($alumnidata){
            return $alumnidata;
        }
    }

    public static function getAngkatan(){
        $alumnidata = tb_angkatan::where('id_angkatan', $id)->first();
        return $alumnidata;
    }

}
