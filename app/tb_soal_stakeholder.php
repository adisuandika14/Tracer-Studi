<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class tb_soal_stakeholder extends Model
{
    use SoftDeletes;
    protected $table = 'tb_soal_stakeholder';
    protected $primaryKey = 'id_soal_stakeholder';
    protected $fillable = [
        'id_soal_stakeholder','pertanyaan',
    ];

    public function relasiSoalstakeholdertoOpsistakeholder()
    {
        return $this->belongsTo('App\tb_opsi_soal_stakeholder','id_opsi_soal_stakeholder','id_opsi_soal_stakeholder');
    }

    public function relasiSoalStakeholdertoProdi()
    {
        return $this->belongsTo('App\tb_prodi','id_prodi','id_prodi');
    }
}
