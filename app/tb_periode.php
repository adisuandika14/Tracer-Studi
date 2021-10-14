<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class tb_periode extends Model
{
    use SoftDeletes;
    protected $table = 'tb_periode';
    protected $primaryKey = 'id_periode';
    protected $fillable = [
        'id_periode','periode',
    ];


    public function relasiPeriodetoKuesioner()
    {
        return $this->belongsTo('App\tb_kuesioner','id_periode','id_periode');
    }

    public function relasiPeriodetoDetailKuesioner()
    {
        return $this->belongsTo('App\tb_detail_kuesioner','id_periode','id_periode');
    }

    public function relasiPeriodetoJawaban()
    {
        return $this->belongsTo('App\tb_jawaban','id_jawaban','id_jawaban');
    }
}
