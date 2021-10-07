<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\Alumni as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Alumni extends Authenticatable
{
    protected $table = 'tb_alumni';
    protected $primaryKey = 'id_alumni';
    protected $fillable = [
        'id_alumni','id_kota','id_prodi','id_angkatan','jenis_kelamin','nik','email','nama_alumni', 'nim_alumni',
        'tahun_lulus','tahun_wisuda','alamat_alumni','no_hp','id_line','id_telegram',
    ];

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'nama', 'email', 'password',
    // ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
