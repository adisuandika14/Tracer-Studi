<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class tb_stakeholder extends Model
{
    use SoftDeletes;
    protected $table = 'tb_stakeholder';
    protected $primaryKey = 'id_stakeholder';
    protected $fillable = [
        'id_stakeholder','id_prodi','pertanyaan','id_jawaban','id_jawaban_stkeholder',
    ];


    public function relasiStackholderKuesionertoProdi()
    {
        return $this->belongsTo('App\tb_prodi','id_prodi','id_prodi');
    }

    public function relasiKuesionerStackholdertoOpsi()
    {
        return $this->belongsTo('App\tb_opsi_stackholder','id_opsi_stackholder','id_opsi_stackholder');
    }

    public function relasiStakeholtoJawbaanStakeholder()
    {
        return $this->belongsTo('App\tb_jawaban_stakeholder','id_jawaban_stakeholder','id_jawaban_stakeholder');
    }

    public function relasiStakeholtoPeriode()
    {
        return $this->belongsTo('App\tb_periode_kuesioner','id_periode_kuesioner','id_periode_kuesioner');
    }

}