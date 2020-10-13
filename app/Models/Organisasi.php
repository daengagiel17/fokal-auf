<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organisasi extends Model
{
    protected $fillable = [
        'anggota_id', 'nama', 'lingkup', 'jabatan',
        'tahun_awal', 'tahun_akhir', 'kabupaten_id', 'provinsi_id'
    ];

    public function anggota()
    {
        return $this->belongsTo('App\Models\Anggota');
    }

    public function kabupaten()
    {
        return $this->belongsTo('App\Models\Kabupaten')->withDefault([
            'nama' => '-'
        ]);
    }

    public function provinsi()
    {
        return $this->belongsTo('App\Models\Provinsi')->withDefault([
            'nama' => '-'
        ]);
    }
}
