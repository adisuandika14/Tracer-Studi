<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class tb_lowongan extends Model
{
    protected $table = 'tb_lowongan';
    protected $primaryKey = 'id_lowongan';
    protected $fillable = [
        'id_lowongan','nama_pekerjaan','jenis_pekerjaan','tanggal_post','keterangan',
    ];

    public function relasilowongantoNotifikasi()
    {
        return $this->belongsTo('App\tb_notifikasi','id_lowongan','id_lowongan');
    }

}
