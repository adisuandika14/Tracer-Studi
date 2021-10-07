<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class tb_opsi_stackholder extends Model
{
    use SoftDeletes;
    protected $table = 'tb_opsi_stackholder';
    protected $primaryKey = 'id_opsi_stackholder';
    protected $fillable = [
        'id_opsi_stackholder','opsi',
    ];

    public function relasiOpsitoKuesionerStackholder()
    {
        return $this->belongsTo('App\tb_kuesioner_stackholer','id_opsi_stackholder','id_opsi_stackholder');
    }

}
