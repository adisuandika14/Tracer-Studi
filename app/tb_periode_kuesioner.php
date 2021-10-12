<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class tb_periode_kuesioner extends Model
{
    protected $table = 'tb_periode_kuesioner';
    protected $primaryKey = 'id_periode_kuesioner';
    protected $fillable = [
        'id_periode_kuesioner','tahun_periode','id_periode','id_tahun_periode',
    ];

    public function relasiPeriodekuesionertoTahun()
    {
        return $this->belongsTo('App\tb_tahun_periode','id_tahun_periode','id_tahun_periode');
    }

    public function relasiPeriodekuesionertoPeriode()
    {
        return $this->belongsTo('App\tb_periode','id_periode','id_periode');
    }


}
