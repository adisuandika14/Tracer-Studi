<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\Alumni as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Stakeholder extends Authenticatable
{
    protected $table = 'tb_stakeholder';
    protected $primaryKey = 'id_stakeholder';
    protected $fillable = [
        'id_stakeholder','id_prodi','pertanyaan','id_jawaban','id_jawaban_stkeholder',
    ];

    use Notifiable;

    public function getAuthPassword() {
        return bcrypt($this->nama_instansi);
    }
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
