<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class tb_pengumuman extends Model
{
    protected $table = 'tb_pengumuman';
    protected $primaryKey = 'id_pengumuman';
    protected $fillable = [
        'id_pengumuman','pengumuman','jenis','judul','sifat_surat','lampiran','thumbnail','lampiran_name','thumbnail_name',
    ];

    public function relasiPengumumantoNotifikasi()
    {
        return $this->belongsTo('App\tb_notifikasi','id_pengumuman','id_pengumuman');
    }

    public function relasiPengumumantoDetail()
    {
        return $this->belongsTo('App\tb_detail_pengumuman','id_pengumuman','id_pengumuman');
    }

    public function routeNotificationForTelegram()
    {
        return $this->chat_id;
    }

}
