<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class tb_angkatan extends Model
{
    protected $table = 'tb_angkatan';
    protected $primaryKey = 'id_angkatan';
    protected $fillable = [
        'id_angkatan','tahun_angkatan',
    ];


    public function relasiAlumnitoAngkatan()
    {
        return $this->belongsTo('App\tb_alumni','id_angkatan','id_angkatan');
    }

}
