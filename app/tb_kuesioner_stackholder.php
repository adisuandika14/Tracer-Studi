<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class tb_kuesioner_stackholder extends Model
{
    use SoftDeletes;
    protected $table = 'tb_kuesioner_stackholder';
    protected $primaryKey = 'id_kuesioner_stackholder';
    protected $fillable = [
        'id_kuesioner_stackholder','id_prodi','pertanyaan','id_jawaban',
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