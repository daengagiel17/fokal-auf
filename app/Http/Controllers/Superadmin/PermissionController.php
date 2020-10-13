<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::orderBy('created_at', 'DESC')->paginate(10);
        return view('superadmin.permission.index', compact('permissions'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:50'
        ]);
        
        $permission = Permission::firstOrCreate([
            'name' => $request->name
        ]);

        return redirect()->back()->with(['success' => 'Permission <strong>' . $permission->name . '</strong> berhasil ditambahkan']);
    }    

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();
        
        return redirect()->back()->with(['success' => 'Permission <strong>' . $permission->name . '</strong> berhasil dihapus']);
    }    
}
