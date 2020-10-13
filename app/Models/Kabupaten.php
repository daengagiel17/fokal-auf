<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    protected $fillable = [
        'provinsi_id', 'nama',
    ];

    public function provinsi()
    {
        return $this->belongsTo('App\Models\Provinsi');
    }

    public function anggota()
    {
        return $this->hasMany('App\Models\Anggota');
    }

    public function pekerjaan()
    {
        return $this->hasMany('App\Models\Pekerjaan');
    }

    public function organisasi()
    {
        return $this->hasMany('App\Models\Organisasi');
    }
}
