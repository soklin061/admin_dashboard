<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-900 leading-tight">
            {{ __('Edit Role') }}: <span class="text-indigo-600">{{ $role->name }}</span>
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Role Name -->
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-1">{{ __('Role Name') }}</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $role->name) }}" required autofocus class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Permissions Grouped -->
                        @php
                            $groupedPermissions = $permissions->groupBy(function($p) {
                                $name = strtolower($p->name);
                                if (str_contains($name, 'user')) return __('User Management');
                                if (str_contains($name, 'role')) return __('Role Management');
                                if (str_contains($name, 'permission')) return __('Permission Management');
                                if (str_contains($name, 'setting')) return __('System Settings');
                                if (str_contains($name, 'log')) return __('Activity Logs');
                                return __('Other');
                            });
                        @endphp

                        <div class="mb-8 space-y-4">
                            <label class="block text-sm font-bold text-gray-700">{{ __('Assign Permissions') }}</label>
                            
                            @foreach($groupedPermissions as $groupName => $groupPerms)
                                <div x-data="{ 
                                    selectAll: false,
                                    toggleAll() {
                                        let checkboxes = $el.querySelectorAll('.perm-checkbox');
                                        checkboxes.forEach(c => c.checked = this.selectAll);
                                    }
                                }" class="bg-slate-50/70 rounded-2xl p-4 border border-gray-200">
                                    <div class="flex items-center justify-between pb-3 mb-3 border-b border-gray-200/80">
                                        <h4 class="text-xs font-bold text-gray-800 uppercase tracking-wider flex items-center">
                                            <span class="w-2.5 h-2.5 rounded-full bg-indigo-500 mr-2"></span>
                                            {{ $groupName }}
                                        </h4>
                                        <label class="inline-flex items-center text-xs font-semibold text-indigo-600 cursor-pointer hover:text-indigo-800">
                                            <input type="checkbox" x-model="selectAll" @change="toggleAll()" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 mr-1.5 h-3.5 w-3.5">
                                            <span>{{ __('Select All') }}</span>
                                        </label>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2.5">
                                        @foreach($groupPerms as $permission)
                                            <label class="inline-flex items-center p-2 rounded-xl bg-white border border-gray-100 hover:border-indigo-200 transition cursor-pointer shadow-2xs">
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                                    @checked($role->hasPermissionTo($permission->name))
                                                    class="perm-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 h-4 w-4">
                                                <span class="ms-2 text-xs font-medium text-gray-700">{{ $permission->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                            <a href="{{ route('admin.roles.index') }}" class="inline-flex items-center px-4 py-2.5 bg-white border border-gray-300 rounded-xl font-semibold text-xs text-gray-700 uppercase tracking-wider shadow-sm hover:bg-gray-50 transition">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2.5 bg-indigo-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-wider hover:bg-indigo-700 active:bg-indigo-800 transition shadow-sm">
                                {{ __('Save Changes') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
