<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Roles & Permissions') }}
                </h2>
                <p class="text-xs text-gray-500 mt-1">{{ __('Configure role capabilities and permissions assigned to users.') }}</p>
            </div>
            @can(['create-roles', 'manage-roles'])
            <a href="{{ route('admin.roles.create') }}" class="inline-flex items-center px-4 py-2.5 bg-indigo-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-wider hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                <i data-lucide="plus" class="w-4 h-4 mr-1.5"></i>
                {{ __('Add New Role') }}
            </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-6">
                    <div class="overflow-x-auto rounded-2xl border border-gray-200/80">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-slate-50/80 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Name') }}</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Granted Permissions') }}</th>
                                    @can(['edit-roles', 'update-roles', 'delete-roles', 'manage-roles'])
                                    <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($roles as $role)
                                    @php
                                        $groupedPermissions = $role->permissions->groupBy(function($p) {
                                            $name = strtolower($p->name);
                                            if (str_contains($name, 'user')) return __('User Management');
                                            if (str_contains($name, 'role')) return __('Role Management');
                                            if (str_contains($name, 'permission')) return __('Permission Management');
                                            if (str_contains($name, 'setting')) return __('System Settings');
                                            if (str_contains($name, 'log')) return __('Activity Logs');
                                            return __('Other');
                                        });
                                        $isFullAccess = $role->permissions->count() > 0 && $role->permissions->count() >= ($totalPermissionsCount ?? 20);
                                    @endphp
                                    <tr class="hover:bg-slate-50/70 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="p-2.5 rounded-xl bg-purple-50 text-purple-600 mr-3 border border-purple-100/80 shadow-2xs">
                                                    <i data-lucide="shield" class="w-5 h-5"></i>
                                                </div>
                                                <div>
                                                    <a href="{{ route('admin.roles.show', $role->id) }}" class="text-sm font-bold text-gray-900 hover:text-indigo-600 transition block">
                                                        {{ $role->name }}
                                                    </a>
                                                    <span class="text-xs text-gray-400 font-medium">{{ $role->permissions->count() }} {{ __('Permissions') }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            @if($role->permissions->isEmpty())
                                                <span class="text-gray-400 text-xs italic">{{ __('No permissions associated') }}</span>
                                            @elseif($isFullAccess)
                                                <div class="flex items-center space-x-3">
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/80 shadow-2xs">
                                                        <i data-lucide="check" class="w-3.5 h-3.5 mr-1.5 text-emerald-600"></i>
                                                        {{ __('Full Access') }} ({{ $role->permissions->count() }})
                                                    </span>
                                                    @can(['show-roles', 'view-roles', 'manage-roles'])
                                                    <a href="{{ route('admin.roles.show', $role->id) }}" class="inline-flex items-center px-3.5 py-1.5 text-xs font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-600 hover:text-white rounded-xl transition duration-150 border border-indigo-100 shadow-2xs">
                                                        <i data-lucide="eye" class="w-3.5 h-3.5 mr-1.5"></i>
                                                        {{ __('View Details') }}
                                                    </a>
                                                    @endcan
                                                </div>
                                            @else
                                                <div class="flex items-center flex-wrap gap-2">
                                                    @foreach($groupedPermissions as $groupName => $groupPerms)
                                                        <span class="inline-flex items-center px-3 py-1 rounded-xl text-xs font-semibold bg-indigo-50/80 text-indigo-700 border border-indigo-100">
                                                            {{ $groupName }}: <span class="ml-1.5 font-bold text-indigo-900">{{ $groupPerms->count() }}</span>
                                                        </span>
                                                    @endforeach
                                                    @can(['show-roles', 'view-roles', 'manage-roles'])
                                                    <a href="{{ route('admin.roles.show', $role->id) }}" class="inline-flex items-center px-3.5 py-1.5 text-xs font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-600 hover:text-white rounded-xl transition duration-150 border border-indigo-100 shadow-2xs">
                                                        <i data-lucide="eye" class="w-3.5 h-3.5 mr-1.5"></i>
                                                        {{ __('View Details') }}
                                                    </a>
                                                    @endcan
                                                </div>
                                            @endif
                                        </td>
                                        @can(['edit-roles', 'update-roles', 'delete-roles', 'manage-roles'])
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end space-x-2">
                                                @can(['edit-roles', 'update-roles', 'manage-roles'])
                                                <a href="{{ route('admin.roles.edit', $role->id) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-50 text-indigo-700 hover:bg-indigo-600 hover:text-white border border-indigo-100 rounded-xl text-xs font-semibold transition duration-150 shadow-2xs">
                                                    <i data-lucide="edit-3" class="w-3.5 h-3.5 mr-1"></i>
                                                    {{ __('Edit') }}
                                                </a>
                                                @endcan
                                                
                                                @can(['delete-roles', 'manage-roles'])
                                                <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" class="inline-block delete-form" data-confirm-title="Delete Role" data-confirm-message="Are you sure you want to delete the role '{{ $role->name }}'? This action cannot be undone.">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-rose-50 text-rose-700 hover:bg-rose-600 hover:text-white border border-rose-100 rounded-xl text-xs font-semibold transition duration-150 shadow-2xs">
                                                        <i data-lucide="trash-2" class="w-3.5 h-3.5 mr-1"></i>
                                                        {{ __('Delete') }}
                                                    </button>
                                                </form>
                                                @endcan
                                            </div>
                                        </td>
                                        @endcan
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center">
                                            <i data-lucide="shield-off" class="w-12 h-12 text-gray-300 mx-auto mb-3"></i>
                                            <p class="text-sm font-medium text-gray-500">{{ __('No roles found.') }}</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-5">
                        {{ $roles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
