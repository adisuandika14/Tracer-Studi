<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class tb_alumni extends Model
{
    use SoftDeletes;
    protected $table = 'tb_alumni';
    protected $primaryKey = 'id_alumni';
    protected $fillable = [
        'id_alumni','id_kota','id_prodi','id_angkatan','chat_id','jenis_kelamin','nik','email_alumni','nama_alumni', 'nim_alumni', 'tahun_lulus','tahun_wisuda','alamat_alumni','no_hp','id_line','id_telegram',
    ];


    public function employee()
    {
        return $this->belongsTo('App\tb_prodi');
    } 

    public function up() 
    { 
        Schema::create('tb_alumni', function (Blueprint $table) 
        {
            $table->increments('id_alumni'); 
            $table->integer('id_prodi'); 
            $table->string('nama_alumni');
            $table->string('nik'); 
            $table->string('jenis_kelamin'); 
            $table->integer('chat_id'); 
            $table->string('nim_alumni'); 
            $table->string('tahun_angkatan'); 
            $table->string('nama_prodi'); 
            $table->string('alamat_alumni'); 
            $table->string('tahun_lulus'); 
            $table->string('tahun_wisuda');
            $table->string('no_hp'); 
            $table->string('email_alumni');  
            $table->foreign('id_prodi')->references('id_prodi')->on('tb_prodi'); 
            $table->timestamps();
    
        });
    }

    public function relasiAlumnitoNotifikasi()
    {
        return $this->belongsTo('App\tb_notifikasi','id_notifikasi','id_notifikasi');
    }



    public function relasiAlumniTokota()
    {
        return $this->belongsTo('App\tb_kota','id_kota','id_kota');
    }

    public function relasiAlumnitoProdi()
    {
        return $this->belongsTo('App\tb_prodi','id_prodi','id_prodi');
    }

    public function relasiDAlumnitoDetailKuesioner()
    {
        return $this->belongsTo('App\tb_detail_kuesioner','id_alumni','id_alumni');
    }

    public function relasiAlumnitoAngkatan()
    {
        return $this->belongsTo('App\tb_angkatan','id_angkatan','id_angkatan');
    }

    public function relasiAlumnitoGender()
    {
        return $this->belongsTo('App\tb_gender','id_gender','id_gender');
    }
    public function relasiAlumnitoJawaban()
    {
        return $this->belongsTo('App\tb_jawaban','id_jawaban','id_jawaban');
    }
    public function relasiAlumnitoperiodealumni()
    {
        return $this->belongsTo('App\tb_periodealumni','id_periode_alumni','id_periode_alumni');
    }

    public function routeNotificationForTelegram()
    {
        return '584467570';
    }

    // function anggota_enum ($table, $field)
    // {
    //     $query = "SHOW COLUMN FROM".$table." LIKE '$field'";
    //     $row = $this->query("SHOW COLUMNS FROM ".$table."LIKE '$field'")->row()->type;
    //     $regex = "/'(.*?)'/";
    //     preg_match_all($regex, $row, $enum_array);
    //     $enum_fields = $enum_array[1];
    //     foreach ($enum_fields as $key=>value)
    //     {
    //         $enums[$value] = $value;
    //     }
    //     return $enums;
    // }


    public function prodi()
    {
        //return $this->belongsTo('App\tb_prodi','id_prodi','id_prodi');
        return $this->hasOne(tb_prodi::class);
    }
    public function relasiDetailkuesionertoPeriode()
    {
        return $this->belongsTo('App\tb_detail_kuesioner','id_periode','id_periode');
    }

}
