<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class tb_kuesioner extends Model
{
    protected $table = 'tb_kuesioner';
    protected $primaryKey = 'id_kuesioner';
    protected $fillable = [
        'id_kuesioner','type_kuesioner','id_master','id_detail_kuesioner'
    ];

    public function relasikuesionertoMasterKuesioner()
    {
        return $this->belongsTo('App\tb_master_kuesioner','id_master','id_master');
    }

    public function relasikuesionertoDetailKuesioner()
    {
        return $this->belongsTo('App\tb_detail_kuesioner','id_detail_kuesioner','id_detail_kuesioner');
    }
}
