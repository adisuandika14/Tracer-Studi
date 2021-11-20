<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class tb_periodealumni extends Model
{
    use SoftDeletes;

    protected $table = 'tb_periodealumni';
    protected $primaryKey = 'id_periode_alumni';
    protected $fillable = [
        'id_periode_alumni','tahun_periode','id_periode','id_tahun_periode',
    ];

    public function relasiPeriodealumnitoTahun()
    {
        return $this->belongsTo('App\tb_tahun_periode','id_tahun_periode','id_tahun_periode');
    }

    public function relasiPeriodealumnitoPeriode()
    {
        return $this->belongsTo('App\tb_periode','id_periode','id_periode');
    }

    public function relasiPeriodetoalumni()
    {
        return $this->belongsTo('App\tb_alumni','id_alumni','id_alumni');
    }
}
