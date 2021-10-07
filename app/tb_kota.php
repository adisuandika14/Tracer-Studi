<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class tb_kota extends Model
{
    protected $table = 'tb_kota';
    protected $primaryKey = 'id_kota';
    protected $fillable = [
        'id_kota','id_provinsi','nama_kota',
    ];

    public function relasiKotaToProvinsi()
    {
        return $this->belongsTo('App\tb_provinsi','id_provinsi','id_provinsi');
    }

    public function relasiKotatoAlumni()
    {
        return $this->belongsTo('App\tb_alumni','id_kota','id_kota');
    }

}
