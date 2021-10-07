<?php

namespace App\Exports;

use App\tb_jawaban;
use Maatwebsite\Excel\Concerns\FromCollection;

class TracerExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return tb_jawaban::all();
    }
}
