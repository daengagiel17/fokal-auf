<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('created_at', 'DESC')->paginate(10);
        return view('superadmin.role.index', compact('roles'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:50'
        ]);
        
        $role = Role::firstOrCreate([
            'name' => $request->name
        ]);

        return redirect()->back()->with(['success' => 'Role <strong>' . $role->name . '</strong> ditambahkan']);
    }    

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        
        return redirect()->back()->with(['success' => 'Role <strong>' . $role->name . '</strong> dihapus']);
    }


    public function rolePermissions($id)
    {
        //select role berdasarkan namenya, ini sejenis dengan method find()
        $role = Role::find($id);
        
        //Mengambil permission yang telah dimiliki oleh role terkait
        $hasPermission = $role->permissions()->pluck('name');
        
        //Mengambil data permission
        $permissions = Permission::all()->pluck('name');

        return view('superadmin.role.permissions', compact('role', 'permissions', 'hasPermission'));
    }
    
    public function setPermissions(Request $request, $id)
    {
        //select role berdasarkan namanya
        $role = Role::find($id);
        
        //fungsi syncPermission akan menghapus semua permissio yg dimiliki role tersebut
        //kemudian di-assign kembali sehingga tidak terjadi duplicate data
        $role->syncPermissions($request->permission);

        return redirect()->back()->with(['success' => 'Permission to role saved!']);
    }    
}
