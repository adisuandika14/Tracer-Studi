<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class admins extends Model
{
    protected $table = 'users';
    protected $fillable = [
        'id','name','nama_depan','nama_belakang','email','email_verified_at','password','remember_token','alamat','no_hp','hak_akses','foto_user',
    ];
}