<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class tb_detail_pengumuman extends Model
{
    protected $table = 'tb_detail_pengumuman';
    protected $primaryKey = 'id_detail_pengumuman';
    protected $fillable = [
        'id_detail_pengumuman','lampiran_name','thumbnail_name','thumbnail','lampiran','perihal',
    ];

    public function relasiDetailtoPengumuman()
    {
        return $this->belongsTo('App\tb_pengumuman','id_pengumuman','id_pengumuman');
    }

}
