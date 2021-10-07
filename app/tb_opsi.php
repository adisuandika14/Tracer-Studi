<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class tb_opsi extends Model
{
    use SoftDeletes;
    protected $table = 'tb_opsi';
    protected $primaryKey = 'id_opsi';
    protected $fillable = [
        'id_opsi','opsi',
    ];

    public function relasiOpsitoKuesioner()
    {
        return $this->belongsTo('App\tb_detail_kuesioner','id_opsi','id_opsi');
    }

}
