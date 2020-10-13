<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $dates = [
        'tanggal_lahir'
    ];

    protected $fillable = [
        'nama', 'email', 'foto', 'no_hp', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin',
        'tahun_dad', 'jurusan_id',  'rayon_id', 'kabupaten_id', 'provinsi_id', 'alamat', 'is_verify'
    ];

    public function user()
    {
        return $this->hasOne('App\User');
    }

    public function jurusan()
    {
        return $this->belongsTo('App\Models\Jurusan');
    }

    public function rayon()
    {
        return $this->belongsTo('App\Models\Rayon');
    }

    public function provinsi()
    {
        return $this->belongsTo('App\Models\Provinsi')->withDefault([
            'nama' => 'Belum diisi'
        ]);
    }

    public function kabupaten()
    {
        return $this->belongsTo('App\Models\Kabupaten')->withDefault([
            'nama' => 'Belum diisi'
        ]);
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
