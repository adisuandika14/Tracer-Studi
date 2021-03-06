<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class tb_jawaban_stakeholder extends Model
{
    use SoftDeletes;
    protected $table = 'tb_jawaban_stakeholder';
    protected $primaryKey = 'id_jawaban_stakeholder';
    protected $fillable = [
        'id_jawaban_stakeholder','id_prodi','pertanyaan','id_jawaban',
    ];

    public function relasiJawabantoKuesioner()
    {
        return $this->belongsTo('App\tb_kuesioner_stakeholder','id_kuesioner_stakeholder','id_kuesioner_stakeholder');
    }

    public function relasiTackholderKuesionertoProdi()
    {
        return $this->belongsTo('App\tb_prodi','id_prodi','id_prodi');
    }

    public function relasiKuesionerStackholdertoOpsi()
    {
        return $this->belongsTo('App\tb_opsi_stackholder','id_opsi_stackholder','id_opsi_stackholder');
    }

    public function relasiJawabanstakeholdertoStakeholder()
    {
        return $this->belongsTo('App\tb_stakeholder','id_stakeholder','id_stakeholder');
    }
}
