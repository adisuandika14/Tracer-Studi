<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class tb_provinsi extends Model
{
    protected $table = 'tb_provinsi';
    protected $primaryKey = 'id_provinsi';
    protected $fillable = [
        'id_provinsi','nama_provinsi',
    ];

    public function relasiProvinsitoKota()
    {
        return $this->belongsTo('App\tb_kota','id_provinsi','id_provinsi');
    }

}
