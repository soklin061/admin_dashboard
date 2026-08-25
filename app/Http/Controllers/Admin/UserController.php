<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:view-users|manage-users', ['only' => ['index']]);
        $this->middleware('can:show-users|view-users|manage-users', ['only' => ['show']]);
        $this->middleware('can:create-users|manage-users', ['only' => ['create', 'store']]);
        $this->middleware('can:edit-users|update-users|manage-users', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete-users|manage-users', ['only' => ['destroy']]);
    }

    public function index()
    {
        $users = User::with('roles')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load(['roles.permissions', 'permissions']);
        return view('admin.users.show', compact('user'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'roles' => ['nullable', 'array']
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($request->has('roles')) {
            $user->syncRoles($request->roles);
        }

        // Log activity
        activity()
            ->performedOn($user)
            ->causedBy(auth()->user())
            ->log('created a new user: ' . $user->name);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'roles' => ['nullable', 'array']
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        $user->syncRoles($request->roles ?? []);

        // Log activity
        activity()
            ->performedOn($user)
            ->causedBy(auth()->user())
            ->log('updated user: ' . $user->name);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'You cannot delete yourself.');
        }

        $userName = $user->name;
        $user->delete();

        // Log activity
        activity()
            ->causedBy(auth()->user())
            ->log('deleted user: ' . $userName);

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
