<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class tb_gender extends Model
{
    protected $table = 'tb_gender';
    protected $primaryKey = 'id_gender';
    protected $fillable = [
        'id_gender','gender',
    ];

    public function relasiGendertoAlumni()
    {
        return $this->belongsTo('App\tb_alumni','id_gender','id_gender');
    }

}
