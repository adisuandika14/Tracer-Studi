<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class tb_opsi_soal_stakeholder extends Model
{
    use SoftDeletes;
    protected $table = 'tb_opsi_soal_stakeholder';
    protected $primaryKey = 'id_soal_stakeholder';
    protected $fillable = [
        'id_soal_stakeholder','opsis',
    ];

    public function relasiOpsitoSoalstakeholder()
    {
        return $this->belongsTo('App\tb_soal_stakeholder','id_soal_stakeholder','id_soal_stakeholder');
    }

}
