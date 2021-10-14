<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class tb_soal_alumni extends Model
{
    use SoftDeletes;
    protected $table = 'tb_soal_alumni';
    protected $primaryKey = 'id_soal_alumni';
    protected $fillable = [
        'id_soal_alumni','pertanyaan',
    ];

    public function relasibanktoOpsi()
    {
        return $this->belongsTo('App\tb_opsi_bank_soal','id_opsi_bank_soal','id_opsi_bank_soal');
    }

}
