<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;
use App\Models\Rayon;
use Yajra\Datatables\Datatables;

class DatabaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('user.profile');
    }

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
                    return '<a href="'. route('database.show', ['id' => $anggota->id]) .'" class="btn btn-sm btn-info btn-show mb-1"><i class="fa fa-bars"></i></a>';    
                })
                ->addIndexColumn()
                ->toJson();    
        }
        $angkatans = Anggota::distinct('tahun_dad')->pluck('tahun_dad');
        $rayons = Rayon::all();

        return view('database.index', compact('angkatans', 'rayons'));
    }

    public function show($id)
    {
        $anggota = Anggota::findOrFail($id);
        return view('database.show', compact('anggota'));
    }

}
