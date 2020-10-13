<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Pekerjaan;
use App\Models\Anggota;

class PekerjaanController extends Controller
{
    public function show($id)
    {
        $anggota = Anggota::findOrFail($id);
        $provinsis = Provinsi::all();
        $kabupatens = Kabupaten::all()->groupBy('provinsi_id');

        return view('admin.pekerjaan.create', compact('anggota', 'provinsis', 'kabupatens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required',
        ]);

        $pekerjaan = Pekerjaan::create([
            'anggota_id' => $request->anggota_id,
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

        return redirect()->route('admin.anggota.show', ['anggotum' => $pekerjaan->anggota_id])->with(['success' => 'Data perkerjaan anggota berhasil ditambahkan']);
    }

    public function edit($id)
    {
        $pekerjaan = Pekerjaan::findOrFail($id);
        $provinsis = Provinsi::all();
        $kabupatens = Kabupaten::all()->groupBy('provinsi_id');

        return view('admin.pekerjaan.edit', compact('pekerjaan', 'provinsis', 'kabupatens'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis' => 'required',
        ]);

        $pekerjaan = Pekerjaan::where('id', $id)->update([
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

        return redirect()->route('admin.anggota.show', ['anggotum' => $request->anggota_id])->with(['success' => 'Data pekerjaan anggota berhasil diupdate']);
    }

    public function destroy($id)
    {
        $pekerjaan = Pekerjaan::destroy($id);

        return response()->json($pekerjaan);
    }  
}