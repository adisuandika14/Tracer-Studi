<?php

namespace App\Imports;

use App\tb_alumni;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AlumniImport implements ToCollection, WithHeadingRow
{
    public $data;
    public function collection(Collection $rows)
    {
        $this->data = $rows;
    }
}