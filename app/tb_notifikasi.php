<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class tb_notifikasi extends Model
{
    protected $table = 'tb_notifikasi';
    protected $primaryKey = 'id_notifikasi';
    protected $fillable = [
        'id_alumni','pesan',
    ];

    public function relasiNotifikasitoAlumni()
    {
        return $this->belongsTo('App\tb_alumni','id_alumni','id_alumni');
    }
}
