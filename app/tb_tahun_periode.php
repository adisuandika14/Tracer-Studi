<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class tb_tahun_periode extends Model
{
    protected $table = 'tb_tahun_periode';
    protected $primaryKey = 'id_tahun_periode';
    protected $fillable = [
        'id_tahun_periode','tahun_periode',
    ];


    public function relasitahuntoPeriodekuesioenr()
    {
        return $this->belongsTo('App\tb_periode_kuesioner','id_periode_kuesioner','id_periode_kuesioner');
    }


}
