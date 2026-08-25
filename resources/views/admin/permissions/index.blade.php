<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Permissions Management') }}
                </h2>
                <p class="text-xs text-gray-500 mt-1">{{ __('Manage system permission keys and guard boundaries.') }}</p>
            </div>
            @canany(['create-permissions', 'manage-permissions'])
            <a href="{{ route('admin.permissions.create') }}" class="inline-flex items-center px-4 py-2.5 bg-indigo-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-wider hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                <i data-lucide="plus" class="w-4 h-4 mr-1.5"></i>
                {{ __('Add New Permission') }}
            </a>
            @endcanany
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
                                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Permission Key') }}</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Guard Name') }}</th>
                                    @canany(['edit-permissions', 'update-permissions', 'delete-permissions', 'manage-permissions'])
                                    <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($permissions as $permission)
                                    <tr class="hover:bg-slate-50/70 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="p-2.5 rounded-xl bg-blue-50 text-blue-600 mr-3 border border-blue-100/80 shadow-2xs">
                                                    <i data-lucide="key" class="w-5 h-5"></i>
                                                </div>
                                                <span class="text-sm font-bold text-gray-900">{{ $permission->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 border border-gray-200/80 shadow-2xs">
                                                {{ $permission->guard_name }}
                                            </span>
                                        </td>
                                        @canany(['edit-permissions', 'update-permissions', 'delete-permissions', 'manage-permissions'])
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end space-x-2">
                                                @canany(['edit-permissions', 'update-permissions', 'manage-permissions'])
                                                <a href="{{ route('admin.permissions.edit', $permission->id) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-50 text-indigo-700 hover:bg-indigo-600 hover:text-white border border-indigo-100 rounded-xl text-xs font-semibold transition duration-150 shadow-2xs">
                                                    <i data-lucide="edit-3" class="w-3.5 h-3.5 mr-1"></i>
                                                    {{ __('Edit') }}
                                                </a>
                                                @endcanany

                                                @canany(['delete-permissions', 'manage-permissions'])
                                                <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST" class="inline-block delete-form" data-confirm-title="Delete Permission" data-confirm-message="Are you sure you want to delete the permission '{{ $permission->name }}'? This action cannot be undone.">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-rose-50 text-rose-700 hover:bg-rose-600 hover:text-white border border-rose-100 rounded-xl text-xs font-semibold transition duration-150 shadow-2xs">
                                                        <i data-lucide="trash-2" class="w-3.5 h-3.5 mr-1"></i>
                                                        {{ __('Delete') }}
                                                    </button>
                                                </form>
                                                @endcanany
                                            </div>
                                        </td>
                                        @endcanany
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center">
                                            <i data-lucide="key-round" class="w-12 h-12 text-gray-300 mx-auto mb-3"></i>
                                            <p class="text-sm font-medium text-gray-500">{{ __('No permissions found.') }}</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-5">
                        {{ $permissions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
