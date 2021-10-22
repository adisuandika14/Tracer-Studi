<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class tb_jawaban extends Model
{
    use SoftDeletes;
    protected $table = 'tb_jawaban';
    protected $primaryKey = 'id_jawaban';
    protected $fillable = [
        'id_jawaban','id_detail_kuesioner','pertanyaan','id_alumni','jawaban','nama_alumni','id_prodi','id_angkatan','nama_prodi','angkatan', 'id_kuesioner','type_kuesioner','id_periode','periode',
    ];

    public function relasiJawabantoDetail()
    {
        return $this->belongsTo('App\tb_detail_kuesioner','id_detail_kuesioner','id_detail_kuesioner');
    }

    public function relasiJawabantoAlumni()
    {
        return $this->belongsTo('App\tb_alumni','id_alumni','id_alumni');
    }

    public function relasiJawabantoProdi()
    {
        return $this->belongsTo('App\tb_prodi','id_prodi','id_prodi');
    }
    
    public function relasiJawabantoAngkatan()
    {
        return $this->belongsTo('App\tb_angkatan','id_angkatan', 'id_angkatan');
    }

    public function relasiJawabantoPeriode()
    {
        return $this->belongsTo('App\tb_periode','id_periode','id_periode');
    }

    public function relasiDetailtoKuesioner()
    {
        return $this->belongsTo('App\tb_kuesioner','id_kuesioner','id_kuesioner');
    }

    public function relasikuesionertoPeriode()
    {
        return $this->belongsTo('App\tb_periode','id_periode','id_periode');
    }

    public function relasiPeriodekuesionertoPeriode()
    {
        return $this->belongsTo('App\tb_tahun_periode','id_tahun_periode','id_tahun_periode');
    }



}