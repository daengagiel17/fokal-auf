<?php

namespace App\Http\Controllers\Admin;

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

class AnggotaController extends Controller
{
    public function index(DataTables $dataTables, Request $request)
    {
        if(request()->ajax())
        {
            if( $request->angkatan != '' && $request->rayon != '')
            {
                $model = Anggota::with('rayon')->where('tahun_dad', $request->angkatan)->where('rayon_id', $request->rayon)->get();
            }
            elseif( $request->rayon != '')
            {
                $model = Anggota::with('rayon')->where('rayon_id', $request->rayon)->get();
            }
            elseif( $request->angkatan != '')
            {
                $model = Anggota::with('rayon')->where('tahun_dad', $request->angkatan)->get();
            }
            else
            {
                $model = Anggota::with('rayon')->get();
            }

            return $dataTables->collection($model)
                ->addColumn('action', function (Anggota $anggota) {
                    if($anggota->is_verify)
                    {
                        return '<a href="'. route('admin.anggota.show', ['anggotum' => $anggota->id]) .'" class="btn btn-sm btn-info btn-show mb-1"><i class="fa fa-bars"></i></a>';    
                    }
                    else
                    {
                        return '<a href="'. route('admin.anggota.show', ['anggotum' => $anggota->id]) .'" class="btn btn-sm btn-info btn-show mb-1"><i class="fa fa-bars"></i></a>
                        <button class="btn btn-sm btn-success btn-verify" data-id="'.$anggota->id.'">Verifikasi</button>';    
                    }
                })
                ->addIndexColumn()
                ->toJson();    
        }
        $angkatans = Anggota::distinct('tahun_dad')->pluck('tahun_dad');
        $rayons = Rayon::all();

        return view('admin.anggota.index', compact('angkatans', 'rayons'));
    }

    public function show($id)
    {
        $anggota = Anggota::findOrFail($id);
        $jurusans = Jurusan::all();

        return view('admin.anggota.show', compact('anggota', 'jurusans'));
    }

    public function create()
    {
        $jurusans = Jurusan::all();
        $provinsis = Provinsi::all();
        $kabupatens = Kabupaten::all()->groupBy('provinsi_id');

        return view('admin.anggota.create', compact('jurusans', 'provinsis', 'kabupatens'));
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
            'email' => $request->email,
            'foto' => $request->hasFile('foto') ? $dir . $fileName : 'img/anggota/default.png',
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tahun_dad' => $request->tahun_dad,
            'jurusan_id' => $request->jurusan_id,
            'rayon_id' => $request->jurusan_id,
            'alamat' => $request->alamat,
            'is_verify' => true,
            'kabupaten_id' => $request->kabupaten_id,
            'provinsi_id' => $request->provinsi_id,
        ]);

        if(isset($request->email) && strpos($request->email, '@gmail.com'))
        {
            $user = User::updateOrCreate([
                'email' => $anggota->email
            ],[
                'anggota_id' => $anggota->id,
                'name' => $anggota->nama,
                'email' => $anggota->email,
                'foto' => $anggota->foto,
                'password' => bcrypt('fokal123'),                
            ]);
        }

        return redirect()->route('admin.anggota.show', ['anggotum' => $anggota->id])->with(['success' => 'Data anggota berhasil ditambahkan']);
    }

    public function edit($id)
    {
        $anggota = Anggota::findOrFail($id);
        $jurusans = Jurusan::all();
        $provinsis = Provinsi::all();
        $kabupatens = Kabupaten::all()->groupBy('provinsi_id');

        return view('admin.anggota.edit', compact('anggota', 'jurusans', 'provinsis', 'kabupatens'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'jurusan_id' => 'required',
            'tahun_dad' => 'required',
            'foto.*' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $anggota = Anggota::findOrFail($id);

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
        $anggota->email = $request->email;
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

        if(isset($anggota->user))
        {
            $anggota->user()->update([
                'name' => $anggota->nama,
                'email' => $anggota->email,
                'foto' => $anggota->foto,
            ]);
        }

        return redirect()->route('admin.anggota.show', ['anggotum' => $anggota->id])->with(['success' => 'Data anggota berhasil diupdate']);
    }

    public function destroy($id)
    {
        $anggota = Anggota::findOrFail($id);
        $anggota->user()->delete();
        $anggota->pekerjaan()->delete();
        $anggota->organisasi()->delete();
        if (($anggota->foto != 'img/anggota/default.png') && (File::exists($anggota->foto))){
            File::delete($anggota->foto);
        }
        $anggota->delete();

        return response()->json($anggota);
    }  

    public function verify(Request $request, $id)
    {
        $anggota = Anggota::where('id', $id)->update([
            'is_verify' => true
        ]);

        return response()->json($anggota);
    }     
}