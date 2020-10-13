<?php

namespace App\Http\Controllers\Profil;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Jurusan;
use App\Models\Rayon;
use App\Models\Anggota;
use App\User;
use File;
use Auth;

class AnggotaController extends Controller
{
    public function show()
    {
        if(isset(Auth::user()->anggota))
        {
            $anggota = Anggota::findOrFail(Auth::user()->anggota_id);
            $jurusans = Jurusan::all();
    
            return view('profil.anggota.show', compact('anggota', 'jurusans'));    
        }
        $jurusans = Jurusan::all();
        $provinsis = Provinsi::all();
        $kabupatens = Kabupaten::all()->groupBy('provinsi_id');

        return view('profil.anggota.create', compact('jurusans', 'provinsis', 'kabupatens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jurusan_id' => 'required',
            'tahun_dad' => 'required',
            'foto.*' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('foto'))
        {
            $dir = 'img/anggota/';
            $foto = $request->file('foto');
            $extension = strtolower($foto->getClientOriginalExtension()); // get image extension
            $fileName = time() . '.' . $extension; // rename image
            $foto->move($dir, $fileName);
        }

        $anggota = Anggota::create([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'email' => Auth::user()->email,
            'foto' => $request->hasFile('foto') ? $dir . $fileName : 'img/anggota/default.png',
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tahun_dad' => $request->tahun_dad,
            'jurusan_id' => $request->jurusan_id,
            'rayon_id' => $request->jurusan_id,
            'alamat' => $request->alamat,
            'is_verify' => false,
            'kabupaten_id' => $request->kabupaten_id,
            'provinsi_id' => $request->provinsi_id,
        ]);

        $user = User::where('email', Auth::user()->email)->update([
            'anggota_id' => $anggota->id,
            'name' => $anggota->nama,
            'foto' => $anggota->foto,
        ]);

        return redirect()->route('profil.anggota.show')->with(['success' => 'Data sedang diajukan untuk diverifikasi']);
    }

    public function edit()
    {
        $anggota = Anggota::findOrFail(Auth::user()->anggota_id);
        $jurusans = Jurusan::all();
        $provinsis = Provinsi::all();
        $kabupatens = Kabupaten::all()->groupBy('provinsi_id');

        return view('profil.anggota.edit', compact('anggota', 'jurusans', 'provinsis', 'kabupatens'));
    }


    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jurusan_id' => 'required',
            'tahun_dad' => 'required',
            'foto.*' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $anggota = Anggota::findOrFail(Auth::user()->anggota_id);

        if ($request->hasFile('foto')) {
            $dir = 'img/anggota/';
            $foto = $request->file('foto');
            $extension = strtolower($foto->getClientOriginalExtension()); // get image extension
            $fileName = time() . '.' . $extension; // rename image

            if (($anggota->foto != 'img/anggota/default.png') && (File::exists($anggota->foto))){
                File::delete($anggota->foto);
            }

            $foto->move($dir, $fileName);
            $anggota->foto = $dir . $fileName;
        }
    
        $anggota->nama = $request->nama;
        $anggota->no_hp = $request->no_hp;
        $anggota->tempat_lahir = $request->tempat_lahir;
        $anggota->tanggal_lahir = $request->tanggal_lahir;
        $anggota->jenis_kelamin = $request->jenis_kelamin;
        $anggota->tahun_dad = $request->tahun_dad;
        $anggota->jurusan_id = $request->jurusan_id;
        $anggota->rayon_id = $request->jurusan_id;
        $anggota->alamat = $request->alamat;
        $anggota->kabupaten_id = $request->kabupaten_id;
        $anggota->provinsi_id = $request->provinsi_id;
        $anggota->save();

        $anggota->user()->update([
            'name' => $anggota->nama,
            'foto' => $anggota->foto,
        ]);

        return redirect()->route('profil.anggota.show')->with(['success' => 'Data berhasil diupdate']);
    }   
}