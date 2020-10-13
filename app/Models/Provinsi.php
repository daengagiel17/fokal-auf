<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    protected $fillable = [
        'nama',
    ];

    public function kabupaten()
    {
        return $this->hasMany('App\Models\Kabupaten');
    }

    public function anggota()
    {
        return $this->hasMany('App\Models\Anggota');
    }

    public function pekerjaan()
    {
        return $this->hasMany('App\Models\Pekerjaan')->withDefault([
            'nama' => '-'
        ]);
    }

    public function organisasi()
    {
        return $this->hasMany('App\Models\Organisasi')->withDefault([
            'nama' => '-'
        ]);
    }    
}
