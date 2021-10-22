<?php

namespace App\Exports;

use App\tb_alumni;
use App\tb_prodi;
use App\Invoice;
use App\tb_jawaban;
use Illuminate\Contracts\View\View;
//use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Database\Eloquent\Relations\HasOne;


class AlumniExport implements FromCollection, WithMapping, WithHeadings
{


    public function collection(){
        return tb_jawaban::get();

    }

    public function map($alumni) : array{

        $alumni = tb_jawaban::with('relasiJawabantoAlumni','relasiJawabantoDetail')->get();
        return[
            $alumni->relasiJawabantoAlumni->nama_alumni,
            $alumni->relasiJawabantoAlumni->alamat,
            $alumni->relasiJawabantoAlumni->alamat,
            $alumni->relasiJawabantoAlumni->tahun_lulus,
            $alumni->relasiJawabantoAlumni->tahun_wisuda,
            $alumni->relasiJawabantoAlumni->relasiAlumnitoProdi->nama_prodi,
            $alumni->relasiJawabantoAlumni->relasiAlumnitoAngkatan->tahun_angkatan,
            $alumni->relasiJawabantoDetail->relasiDetailtoKuesioner->type_kuesioner,
        ];



    }

    public function headings(): array
    {
        return[

            'Nama Alumni',
            'Alamat',
            'Tahun Lulus',
            'Tahun Wisuda',
            'Program Studi',
            'Angkatan',
            'Status',
        ];
    }


}
