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
        'id_stakeholder','id_prodi','pertanyaan','id_jawaban',
    ];


    public function relasiTackholderKuesionertoProdi()
    {
        return $this->belongsTo('App\tb_prodi','id_prodi','id_prodi');
    }

    public function relasiKuesionerStackholdertoOpsi()
    {
        return $this->belongsTo('App\tb_opsi_stackholder','id_opsi_stackholder','id_opsi_stackholder');
    }
}