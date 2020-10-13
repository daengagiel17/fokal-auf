<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class RegistrasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showRegistrasi()
    {
        return view('auth.registrasi');
    }

    public function registrasi(Request $request)
    {
        $request->validate([
            'no_hp' => 'required',
            'alamat' => 'required',
        ]);

        $user  = User::where('email', $request->email)->update([
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'is_complete' => true,
        ]);

        return redirect()->route('dashboard');
    }
}
