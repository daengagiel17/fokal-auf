<?php

namespace App\Imports;

use App\User;
use App\Models\Anggota;
use App\Models\Kabupaten;
use App\Models\Jurusan;
use App\Models\Pekerjaan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FirstSheetImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $collections)
    {
        foreach ($collections as $collection) 
        {
            if($collection['nama'] != null)
            {    
                $jurusan = Jurusan::where('nama', $collection['jurusan'])->first();
                $kabupaten = Kabupaten::where('nama', $collection['kabupaten'])->first();
                
                $anggota = Anggota::create([
                    'nama' => ucwords($collection['nama']),
                    'no_hp' => $collection['no_hp'],
                    'email' => $collection['email'],
                    'foto' => 'img/anggota/default.png',
                    'tempat_lahir' => $collection['tempat_lahir'],
                    'tanggal_lahir' => $collection['tanggal_lahir'],
                    'jenis_kelamin' => $collection['jenis_kelamin'],
                    'tahun_dad' => $collection['angkatan'],
                    'jurusan_id' => $jurusan->id,
                    'rayon_id' => $jurusan->id,
                    'alamat' => ucwords($collection['alamat']),
                    'kabupaten_id' => isset($kabupaten) ? $kabupaten->id : null,
                    'provinsi_id' => isset($kabupaten) ? $kabupaten->provinsi_id : null,
                    'is_verify' => true,
                ]);
        
                if($collection['pekerjaan'] != '')
                {
                    $kabupaten = Kabupaten::where('nama', $collection['lokasi_pekerjaan'])->first();
    
                    $pekerjaan = Pekerjaan::create([
                        'anggota_id' => $anggota->id,
                        'jenis' => $collection['pekerjaan'],
                        'perusahaan' => $collection['perusahaan'],
                        'departemen' => $collection['departemen'],
                        'jabatan' => $collection['jabatan'],
                        'deskripsi' => $collection['deskripsi_pekerjaan'],
                        'kabupaten_id' => isset($kabupaten) ? $kabupaten->id : null,
                        'provinsi_id' => isset($kabupaten) ? $kabupaten->provinsi_id : null,
                    ]);
                }   
                
                if($collection['email'] != '')
                {
                    $user = User::updateOrcreate([
                        'email' => $anggota->email
                    ],[
                        'anggota_id' => $anggota->id,
                        'name' => $anggota->nama,
                        'password' => bcrypt('fokal123'),
                        'foto' => $anggota->foto,
                    ]);
                }
            }
        }
    }
}