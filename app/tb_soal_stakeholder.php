<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class tb_soal_stakeholder extends Model
{
    protected $table = 'tb_soal_stakeholder';
    protected $primaryKey = 'id_soal_stakeholder';
    protected $fillable = [
        'id_soal_stakeholder','pertanyaan',
    ];

    public function relasiSoalstakeholdertoOpsistakeholder()
    {
        return $this->belongsTo('App\tb_opsi_bank_soal','id_opsi_stakeholder','id_opsi_stakeholder');
    }

}
