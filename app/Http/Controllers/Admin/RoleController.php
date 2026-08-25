<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:view-roles|manage-roles', ['only' => ['index']]);
        $this->middleware('can:show-roles|view-roles|manage-roles', ['only' => ['show']]);
        $this->middleware('can:create-roles|manage-roles', ['only' => ['create', 'store']]);
        $this->middleware('can:edit-roles|update-roles|manage-roles', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete-roles|manage-roles', ['only' => ['destroy']]);
    }

    public function index()
    {
        $roles = Role::with('permissions')->paginate(10);
        $totalPermissionsCount = Permission::count();
        return view('admin.roles.index', compact('roles', 'totalPermissionsCount'));
    }

    public function show(Role $role)
    {
        $role->load(['permissions', 'users']);
        $totalPermissionsCount = Permission::count();
        return view('admin.roles.show', compact('role', 'totalPermissionsCount'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
            'permissions' => ['nullable', 'array']
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        // Log activity
        activity()
            ->performedOn($role)
            ->causedBy(auth()->user())
            ->log('created a new role: ' . $role->name);

        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name,' . $role->id],
            'permissions' => ['nullable', 'array']
        ]);

        $role->name = $request->name;
        $role->save();

        $role->syncPermissions($request->permissions ?? []);

        // Log activity
        activity()
            ->performedOn($role)
            ->causedBy(auth()->user())
            ->log('updated role: ' . $role->name);

        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        $roleName = $role->name;
        $role->delete();

        // Log activity
        activity()
            ->causedBy(auth()->user())
            ->log('deleted role: ' . $roleName);

        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully.');
    }
}
