<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class tb_master_kuesioner extends Model
{
    protected $table = 'tb_master_kuesioner';
    protected $primaryKey = 'id_master_kuesioner';
    protected $fillable = [
        'id_master','id_prodi',
    ];

    public function relasiMastertoProdi()
    {
        return $this->belongsTo('App\tb_prodi','id_prodi','id_prodi');
    }

    public function relasiMasterKuesionertoKuesioner()
    {
        return $this->belongsTo('App\tb_kuesioner','id_master','id_master');
    }
}
