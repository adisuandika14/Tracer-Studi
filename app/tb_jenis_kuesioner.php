<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class tb_jenis_kuesioner extends Model
{
    protected $table = 'tb_jenis_kuesioner';
    protected $primaryKey = 'id_jenis';
    protected $fillable = [
        'id_jenis','jenis',
    ];

    public function relasiJenistoDetail()
    {
        return $this->belongsTo('App\tb_detail_kuesioner','id_jenis','id_jenis');
    }
}
