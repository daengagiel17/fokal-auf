<?php

namespace App\Imports;

use App\User;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KabupatenImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $collections)
    {
        foreach ($collections as $collection) 
        {
            $provinsi = Provinsi::firstOrCreate([
                'nama' => $collection['provinsi']
            ]);

            Kabupaten::create([
                'nama' => $collection['kabupatenkota'],
                'provinsi_id' => $provinsi->id,
            ]);
        }
    }
}