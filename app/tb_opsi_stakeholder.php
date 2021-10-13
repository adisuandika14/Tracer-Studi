<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class tb_opsi_stakeholder extends Model
{
    use SoftDeletes;
    protected $table = 'tb_opsi_stakeholder';
    protected $primaryKey = 'tb_opsi_stakeholder';
    protected $fillable = [
        'tb_opsi_stakeholder','opsi',
    ];

    public function relasiOpsitoKuesionerStackholder()
    {
        return $this->belongsTo('App\tb_soal_stakeholder','tb_opsi_stakeholder','tb_opsi_stakeholder');
    }

}
