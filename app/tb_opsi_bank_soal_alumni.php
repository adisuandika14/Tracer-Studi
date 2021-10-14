<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class tb_opsi_bank_soal_alumni extends Model
{
    use SoftDeletes;
    protected $table = 'tb_opsi_bank_soal_alumni';
    protected $primaryKey = 'id_opsi_bank_soal_alumni';
    protected $fillable = [
        'id_opsi_bank_soal_alumni','opsis',
    ];

    public function relasiOpsitoBank()
    {
        return $this->belongsTo('App\tb_bank_soal','id_bank_soal','id_bank_soal');
    }

}
