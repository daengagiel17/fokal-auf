<?php

namespace App\Http\Controllers\Profil;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Pekerjaan;
use App\Models\Anggota;
use Auth;

class PekerjaanController extends Controller
{
    public function create()
    {
        $anggota = Anggota::findOrFail(Auth::user()->anggota_id);
        $provinsis = Provinsi::all();
        $kabupatens = Kabupaten::all()->groupBy('provinsi_id');

        return view('profil.pekerjaan.create', compact('anggota', 'provinsis', 'kabupatens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required',
        ]);

        $pekerjaan = Pekerjaan::create([
            'anggota_id' => Auth::user()->anggota_id,
            'jenis' => $request->jenis,
            'perusahaan' => $request->perusahaan,
            'departemen' => $request->departemen,
            'jabatan' => $request->jabatan,
            'tahun_awal' => $request->tahun_awal,
            'tahun_akhir' => $request->tahun_akhir,
            'deskripsi' => $request->deskripsi,
            'kabupaten_id' => $request->kabupaten_id,
            'provinsi_id' => $request->provinsi_id,
        ]);

        return redirect()->route('profil.anggota.show')->with(['success' => 'Data perkerjaan anggota berhasil ditambahkan']);
    }

    public function edit($id)
    {
        $pekerjaan = Pekerjaan::findOrFail($id);
        if(Auth::user()->anggota_id != $pekerjaan->anggota_id)
        {
            abort(403);
        }

        $provinsis = Provinsi::all();
        $kabupatens = Kabupaten::all()->groupBy('provinsi_id');

        return view('profil.pekerjaan.edit', compact('pekerjaan', 'provinsis', 'kabupatens'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis' => 'required',
        ]);

        $pekerjaan = Pekerjaan::findOrFail($id);
        if(Auth::user()->anggota_id != $pekerjaan->anggota_id)
        {
            abort(403);
        }

        $pekerjaan->update([
            'jenis' => $request->jenis,
            'perusahaan' => $request->perusahaan,
            'departemen' => $request->departemen,
            'jabatan' => $request->jabatan,
            'tahun_awal' => $request->tahun_awal,
            'tahun_akhir' => $request->tahun_akhir,
            'deskripsi' => $request->deskripsi,
            'kabupaten_id' => $request->kabupaten_id,
            'provinsi_id' => $request->provinsi_id,
        ]);

        return redirect()->route('profil.anggota.show')->with(['success' => 'Data pekerjaan anggota berhasil diupdate']);
    }

    public function destroy($id)
    {
        $pekerjaan = Pekerjaan::findOrFail($id);
        if(Auth::user()->anggota_id != $pekerjaan->anggota_id)
        {
            abort(403);
        }
        $pekerjaan->delete();

        return response()->json($pekerjaan);
    }  
}