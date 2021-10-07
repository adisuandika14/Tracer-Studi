<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class tb_prodi extends Model
{
    protected $table = 'tb_prodi';
    protected $primaryKey = 'id_prodi';
    protected $fillable = [
        'id_prodi','nama_prodi',
    ];

    public function relasiProditoAlumni()
    {
        return $this->belongsTo('App\tb_alumni','id_prodi','id_prodi');
    }

    public function relasiProditoAdmins()
    {
        return $this->belongsTo('App\admins','id_prodi','id_prodi');
    }

    public function relasiProditoMasterKuesioner()
    {
        return $this->belongsTo('App\tb_master_kuesioner','id_prodi','id_prodi');
    }

    public function relasiProditoNotifikasi()
    {
        return $this->belongsTo('App\tb_notifikasi','id_prodi','id_prodi');
    }

    public function relasiProditoJawaban()
    {
        return $this->belongsTo('App\tb_jawaban','id_jawaban','id_jawaban');
    }

    public function relasiProditosTackholderKuesioner()
    {
        return $this->belongsTo('App\tb_kuesioner_stackholder','id_prodi','id_prodi');
    }

}
