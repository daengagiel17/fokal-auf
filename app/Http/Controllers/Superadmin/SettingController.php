<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kabupaten;
use App\Imports\KabupatenImport;
use App\Models\Anggota;
use App\Imports\AnggotaImport;
use Maatwebsite\Excel\Facades\Excel;

class SettingController extends Controller
{
    public function index()
    {
        return view('superadmin.setting.index'); 
    }
 
	public function importKabupaten(Request $request) 
	{
		$request->validate([
			'file' => 'required'
        ]);
        
		$file = Excel::import(new KabupatenImport, $request->file('file'));
  
		return back()->with(['success' => 'Berhasil mengimport data dari excel']);
    }   

	public function importAnggota(Request $request) 
	{
		$request->validate([
			'file' => 'required'
        ]);
        
		$file = Excel::import(new AnggotaImport, $request->file('file'));
  
		return back()->with(['success' => 'Berhasil mengimport data dari excel']);
    }     
}