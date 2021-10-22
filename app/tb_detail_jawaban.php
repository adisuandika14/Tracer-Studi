<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class tb_detail_jawaban extends Model
{
    use SoftDeletes;
    protected $table = 'tb_detail_jawaban';
    protected $primaryKey = 'id_detail_jawaban';
//    protected $fillable = [
//        'id_jawaban','id_detail_kuesioner','pertanyaan','id_alumni','jawaban','nama_alumni','id_prodi','id_angkatan','nama_prodi','angkatan', 'id_kuesioner','type_kuesioner','id_periode','periode',
//    ];

    public function relasiJawabantoOpsi()
    {
        return $this->belongsTo('App\tb_opsi','jawaban','id_opsi');
    }

    public function relasiJawabantoDetailJawaban()
    {
        return $this->belongsTo('App\tb_jawaban','id_detail_jawaban','id_detail_jawaban');
    }

}
