<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rayon extends Model
{
    protected $fillable = [
        'nama',
    ];

    public function anggota()
    {
        return $this->hasMany('App\Models\Anggota');
    }    
}