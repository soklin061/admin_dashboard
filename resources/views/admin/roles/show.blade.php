<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.roles.index') }}" class="p-2 rounded-xl bg-white border border-gray-200 text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition shadow-sm flex items-center justify-center">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </a>
                <div>
                    <h2 class="font-bold text-2xl text-gray-900 leading-tight flex items-center gap-2">
                        {{ __('Role Details') }}: <span class="text-indigo-600">{{ $role->name }}</span>
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">{{ __('Full breakdown of granted capabilities, guard configurations, and assigned users.') }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                @canany(['edit roles', 'update roles', 'manage roles'])
                <a href="{{ route('admin.roles.edit', $role->id) }}" class="inline-flex items-center px-4 py-2.5 bg-indigo-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-wider hover:bg-indigo-700 active:bg-indigo-800 transition shadow-sm">
                    <i data-lucide="edit-3" class="w-4 h-4 mr-1.5"></i>
                    {{ __('Edit Role') }}
                </a>
                @endcanany
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Role Info Header Card -->
            @php
                $isFullAccess = $role->permissions->count() > 0 && $role->permissions->count() >= ($totalPermissionsCount ?? 20);
                $groupedPermissions = $role->permissions->groupBy(function($p) {
                    $name = strtolower($p->name);
                    if (str_contains($name, 'user')) return __('User Management');
                    if (str_contains($name, 'role')) return __('Role Management');
                    if (str_contains($name, 'permission')) return __('Permission Management');
                    if (str_contains($name, 'setting')) return __('System Settings');
                    if (str_contains($name, 'log')) return __('Activity Logs');
                    return __('Other');
                });
            @endphp

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="flex items-center space-x-4">
                    <div class="p-4 rounded-2xl bg-gradient-to-br from-indigo-50 to-purple-50 text-indigo-600 border border-indigo-100 shadow-sm">
                        <i data-lucide="shield" class="w-8 h-8"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-3">
                            <h3 class="text-xl font-bold text-gray-900">{{ $role->name }}</h3>
                            @if($isFullAccess)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <i data-lucide="check" class="w-3.5 h-3.5 mr-1 text-emerald-600"></i>
                                    {{ __('Full Access') }}
                                </span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Guard Name: <span class="font-semibold text-gray-700">{{ $role->guard_name }}</span> &bull; ID: #{{ $role->id }}</p>
                    </div>
                </div>

                <div class="flex items-center space-x-6 border-t md:border-t-0 md:border-l border-gray-100 pt-4 md:pt-0 md:pl-6">
                    <div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">{{ __('Granted Permissions') }}</span>
                        <span class="text-2xl font-extrabold text-indigo-600">{{ $role->permissions->count() }}</span>
                    </div>
                    <div class="h-8 w-px bg-gray-200"></div>
                    <div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">{{ __('Assigned Users') }}</span>
                        <span class="text-2xl font-extrabold text-purple-600">{{ $role->users->count() }}</span>
                    </div>
                </div>
            </div>

            <!-- Granted Permissions Details Grid -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center justify-between pb-4 mb-6 border-b border-gray-100">
                    <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                        <i data-lucide="key" class="w-5 h-5 text-indigo-600"></i>
                        {{ __('Granted Permissions') }} ({{ $role->permissions->count() }})
                    </h3>
                </div>

                @if($role->permissions->isEmpty())
                    <div class="text-center py-10">
                        <i data-lucide="key-round" class="w-12 h-12 text-gray-300 mx-auto mb-3"></i>
                        <p class="text-sm font-medium text-gray-500">{{ __('No permissions associated with this role.') }}</p>
                    </div>
                @else
                    <div class="space-y-6">
                        @foreach($groupedPermissions as $groupName => $groupPerms)
                            <div class="bg-slate-50/70 rounded-2xl p-5 border border-gray-200/80">
                                <div class="flex items-center justify-between pb-3 mb-4 border-b border-gray-200/80">
                                    <h4 class="text-xs font-bold text-gray-800 uppercase tracking-wider flex items-center">
                                        <span class="w-2.5 h-2.5 rounded-full bg-indigo-500 mr-2"></span>
                                        {{ $groupName }}
                                    </h4>
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-white text-indigo-700 border border-indigo-100 shadow-2xs">
                                        {{ $groupPerms->count() }} {{ __('Permissions') }}
                                    </span>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                                    @foreach($groupPerms as $perm)
                                        <div class="flex items-center px-3.5 py-2.5 rounded-xl bg-white text-emerald-800 border border-emerald-200/80 text-xs font-semibold shadow-2xs">
                                            <i data-lucide="check" class="w-4 h-4 mr-2 text-emerald-600 shrink-0"></i>
                                            <span class="truncate">{{ $perm->name }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Assigned Users List Card -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center justify-between pb-4 mb-6 border-b border-gray-100">
                    <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                        <i data-lucide="users" class="w-5 h-5 text-purple-600"></i>
                        {{ __('Assigned Users') }} ({{ $role->users->count() }})
                    </h3>
                </div>

                @if($role->users->isEmpty())
                    <div class="text-center py-10">
                        <i data-lucide="user-x" class="w-12 h-12 text-gray-300 mx-auto mb-3"></i>
                        <p class="text-sm font-medium text-gray-500">{{ __('No users are currently assigned to this role.') }}</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($role->users as $u)
                            <div class="flex items-center p-3.5 rounded-2xl bg-slate-50/70 border border-gray-200/80 hover:border-indigo-200 transition shadow-2xs">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-600 text-white font-bold flex items-center justify-center text-xs uppercase shadow-sm">
                                    {{ substr($u->name, 0, 2) }}
                                </div>
                                <div class="ml-3 truncate">
                                    <div class="text-sm font-bold text-gray-900 truncate">{{ $u->name }}</div>
                                    <div class="text-xs text-gray-400 truncate">{{ $u->email }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
