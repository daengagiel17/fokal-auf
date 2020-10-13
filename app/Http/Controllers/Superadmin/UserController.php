<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::has('roles')->orderBy('created_at', 'DESC')->paginate(10);
        $role = Role::whereIn('name', ['super-admin', 'admin'])->pluck('id');
        return view('superadmin.user.index', compact('users'));
    }

    public function create()
    {
        $role = Role::orderBy('name', 'ASC')->get();

        return view('superadmin.user.create', compact('role'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|string|exists:roles,name'
        ]);

        $user = User::firstOrCreate([
            'email' => $request->email
        ], [
            'name' => $request->name,
            'password' => bcrypt($request->password),
        ]);

        $user->assignRole($request->role);

        return redirect()->route('superadmin.akses.user.index')->with(['success' => 'User <strong>' . $user->name . '</strong> berhasil ditambahkan']);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('superadmin.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            // 'email' => 'required|email|exists:users',
            'password' => 'nullable|min:6',
        ]);

        $user = User::findOrFail($id);
        $password = empty($request->password) ? $user->password : bcrypt($request->password);
        $user->update([
            'name' => $request->name,
            'password' => $password,
            'email' => $request->email,
        ]);

        return redirect()->route('superadmin.akses.user.index')->with(['success' => 'User <strong>' . $user->name . '</strong> berhasil diperbaharui']);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with(['success' => 'User <strong>' . $user->name . '</strong> berhasil dihapus']);
    }

    public function userRoles(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        //Mengambil roles yang telah dimiliki oleh user terkait
        $hasRole = $user->roles()->pluck('name');
        
        //Mengambil data role
        $roles = Role::all()->pluck('name');


        return view('superadmin.user.roles', compact('user', 'hasRole', 'roles'));
    }

    public function setRoles(Request $request, $id)
    {
        $this->validate($request, [
            'role' => 'required'
        ]);
        
        $user = User::findOrFail($id);
        
        //menggunakan syncRoles agar terlebih dahulu menghapus semua role yang dimiliki
        //kemudian di-set kembali agar tidak terjadi duplicate
        $user->syncRoles($request->role);
        
        return redirect()->route('superadmin.akses.user.roles', $id)->with(['success' => 'Role sudah di set']);
    }
}