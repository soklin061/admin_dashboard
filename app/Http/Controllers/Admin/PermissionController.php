<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::paginate(15);
        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:permissions,name']
        ]);

        $permission = Permission::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);

        // Log activity
        activity()
            ->performedOn($permission)
            ->causedBy(auth()->user())
            ->log('created a new permission: ' . $permission->name);

        return redirect()->route('admin.permissions.index')->with('success', 'Permission created successfully.');
    }

    public function destroy(Permission $permission)
    {
        $permissionName = $permission->name;
        $permission->delete();

        // Log activity
        activity()
            ->causedBy(auth()->user())
            ->log('deleted permission: ' . $permissionName);

        return redirect()->route('admin.permissions.index')->with('success', 'Permission deleted successfully.');
    }
}
