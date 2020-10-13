<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;
use App\Models\Rayon;
use Yajra\Datatables\Datatables;

class HomeController extends Controller
{
    public function home()
    {
        $statistik = $this->getData();
        return view('welcome', compact('statistik'));
    }

    public function getData()
    {
        $anggota  = Anggota::all();

        return [
            'jumlah' => $anggota->count(),
            'angkatan' => $anggota->unique('tahun_dad')->count(),
            'kabupaten' => $anggota->unique('kabupaten')->count(),
            'provinsi' => $anggota->unique('provinsi_id')->count(),
        ];
    }

    public function statistik()
    {
        $anggota = Anggota::all();
        $anggotaRayon = $anggota->groupBy('rayon_id');
        $anggotaAngkatan = $anggota->groupBy('tahun_dad');

        $rayon = [
            'data' => [
                $anggotaRayon[1]->count(),
                $anggotaRayon[3]->count(),
                $anggotaRayon[2]->count(),
                $anggotaRayon[5]->count(),
                $anggotaRayon[4]->count(),
            ],
            'labels' => ['Mesin', 'Elektro', 'Sipil', 'Informatika', 'Industri'],
        ];

        $anggota = [
            'labels' => array(),
            'data' => array()
        ];

        foreach($anggotaAngkatan as $key => $angkatan)
        {
            $anggota['labels'][] = $key;
            $anggota['data'][] = $angkatan->count();
        }

        return response()->json(['rayon' => $rayon, 'anggota' => $anggota]);
    }
}
