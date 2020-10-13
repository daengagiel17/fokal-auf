<?php

namespace App\Http\Controllers\Profil;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Organisasi;
use App\Models\Anggota;
use Auth;

class OrganisasiController extends Controller
{
    public function create()
    {
        $anggota = Anggota::findOrFail(Auth::user()->anggota_id);
        $provinsis = Provinsi::all();
        $kabupatens = Kabupaten::all()->groupBy('provinsi_id');

        return view('profil.organisasi.create', compact('anggota', 'provinsis', 'kabupatens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'lingkup' => 'required',
        ]);

        if($request->lingkup == 'Kabupaten/Kota' && $request->kabupaten_id == null)
        {
            return back()->withInput()->with(['error' => "Lingkup kabupaten/kota harus isi kabupaten"]);
        }
        elseif($request->lingkup == 'Provinsi' && $request->provinsi_id == null)
        {
            return back()->withInput()->with(['error' => "Lingkup provinsi harus isi provinsi"]);
        }

        $organisasi = Organisasi::create([
            'anggota_id' => Auth::user()->anggota_id,
            'nama' => $request->nama,
            'lingkup' => $request->lingkup,
            'jabatan' => $request->jabatan,
            'tahun_awal' => $request->tahun_awal,
            'tahun_akhir' => $request->tahun_akhir,
            'kabupaten_id' => $request->kabupaten_id,
            'provinsi_id' => $request->provinsi_id,
        ]);

        return redirect()->route('profil.anggota.show')->with(['success' => 'Data organisasi anggota berhasil ditambahkan']);
    }

    public function edit($id)
    {
        $organisasi = Organisasi::findOrFail($id);
        if(Auth::user()->anggota_id != $organisasi->anggota_id)
        {
            abort(403);
        }

        $provinsis = Provinsi::all();
        $kabupatens = Kabupaten::all()->groupBy('provinsi_id');

        return view('profil.organisasi.edit', compact('organisasi', 'provinsis', 'kabupatens'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'lingkup' => 'required',
        ]);

        if($request->lingkup == 'Kabupaten/Kota' && $request->kabupaten_id == null)
        {
            return back()->withInput()->with(['error' => "Lingkup kabupaten/kota harus isi kabupaten"]);
        }
        elseif($request->lingkup == 'Provinsi' && $request->provinsi_id == null)
        {
            return back()->withInput()->with(['error' => "Lingkup provinsi harus isi provinsi"]);
        }

        $organisasi = Organisasi::findOrFail($id);
        if(Auth::user()->anggota_id != $organisasi->anggota_id)
        {
            abort(403);
        }

        $organisasi->update([
            'nama' => $request->nama,
            'lingkup' => $request->lingkup,
            'jabatan' => $request->jabatan,
            'tahun_awal' => $request->tahun_awal,
            'tahun_akhir' => $request->tahun_akhir,
            'kabupaten_id' => $request->kabupaten_id,
            'provinsi_id' => $request->provinsi_id,
        ]);

        return redirect()->route('profil.anggota.show')->with(['success' => 'Data organisasi anggota berhasil diupdate']);
    }

    public function destroy($id)
    {
        $organisasi = Organisasi::findOrFail($id);
        if(Auth::user()->anggota_id != $organisasi->anggota_id)
        {
            abort(403);
        }
        $organisasi->delete();

        return response()->json($organisasi);
    }  
}