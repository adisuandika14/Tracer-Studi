<?php

namespace App\Imports;

use App\tb_alumni;
use Illuminate\Database\Schema\Blueprint;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AlumniImport implements ToCollection, WithHeadingRow, WithValidation
{

    use SkipsErrors;
    public $data;
    
    public function rules(): array
    {
        return[
                '*.nama_alumni' => ['nama_alumni', 'unique:nama_alumni']
        ];
    }

    public function collection(Collection $rows)
    {

        $this->data = $rows;
    }


}