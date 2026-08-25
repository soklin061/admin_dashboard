<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:view-permissions|manage-permissions', ['only' => ['index']]);
        $this->middleware('can:create-permissions|manage-permissions', ['only' => ['create', 'store']]);
        $this->middleware('can:edit-permissions|update-permissions|manage-permissions', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete-permissions|manage-permissions', ['only' => ['destroy']]);
    }

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

    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:permissions,name,' . $permission->id]
        ]);

        $permission->name = $request->name;
        $permission->save();

        // Log activity
        activity()
            ->performedOn($permission)
            ->causedBy(auth()->user())
            ->log('updated permission: ' . $permission->name);

        return redirect()->route('admin.permissions.index')->with('success', 'Permission updated successfully.');
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
