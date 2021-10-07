<?php

namespace App\Exports;

use App\tb_alumni;
use App\tb_prodi;
use App\Invoice;
use Illuminate\Contracts\View\View;
//use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Database\Eloquent\Relations\HasOne;


class AlumniExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return tb_alumni::with('tb_prodi','tb_angkatan')->get();

    // }

    // public function relasiAlumnitoProdi ($fromalumni) : array {
    //     return [
    //         $fromalumni->id,
    //         $fromalumni->alumni->nama_alumni,
    //         $fromalumni->alumni->nama_prodi,
    //     ] ;
 
 
    // }


    public function collection(){

            $type = DB::table('tb_alumni')->select('nama_alumni','alamat_alumni','tahun_lulus','tahun_wisuda')->get(); 

            return $type ;

    }

    public function headings(): array
    {
        return[

            'Nama Alumni',
            'Alamat',
            'Tahun Lulus',
            'Tahun Wisuda',
        ];
    }

    // public function alumni()
    // {
    //     return $this->relasiAlumnitoProdi(App\tb_alumni::class, 'id', 'nama_prodi');
    // }

    // public function relasiAlumnitoProdi()
    // {
    //     return $this->belongsTo('App\tb_prodi','id_prodi','id_prodi');
    // }
}
