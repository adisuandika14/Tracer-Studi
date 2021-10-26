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


class AlumniExport implements FromCollection
{


    public function collection(){
        return tb_alumni::get();

    }

    // public function map($alumni) : array{

    //     $alumni = tb_alumni::get();
    //     return[
    //         $alumni->nama_alumni,
    //         $alumni->chat_id,
    //     ];



    // }

    // public function headings(): array
    // {
    //     return[

    //         'Nama Alumni',
    //         'Chat Id',
    //     ];
    // }


}
