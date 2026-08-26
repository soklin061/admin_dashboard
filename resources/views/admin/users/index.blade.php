<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Users Management') }}
                </h2>
                <p class="text-xs text-gray-500 mt-1">{{ __('Manage user access, role assignments, and account details.') }}</p>
            </div>
            @canany(['create-users', 'manage-users'])
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-4 py-2.5 bg-indigo-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-wider hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                <i data-lucide="user-plus" class="w-4 h-4 mr-1.5"></i>
                {{ __('Add New User') }}
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
                                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('User') }}</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Email') }}</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Roles') }}</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Date') }}</th>
                                    @canany(['edit-users', 'update-users', 'delete-users', 'manage-users'])
                                    <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($users as $user)
                                    <tr class="hover:bg-slate-50/70 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-600 text-white font-bold flex items-center justify-center text-xs uppercase shadow-sm">
                                                    {{ substr($user->name, 0, 2) }}
                                                </div>
                                                <div class="ml-3">
                                                    @canany(['show-users', 'view-users', 'manage-users'])
                                                    <a href="{{ route('admin.users.show', $user->id) }}" class="text-sm font-bold text-gray-900 hover:text-indigo-600 transition block">
                                                        {{ $user->name }}
                                                    </a>
                                                    @else
                                                    <div class="text-sm font-bold text-gray-900">
                                                        {{ $user->name }}
                                                    </div>
                                                    @endcanany
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-medium">
                                            {{ $user->email }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @forelse($user->roles as $role)
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100 mr-1 shadow-2xs">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 mr-1.5"></span>
                                                    {{ $role->name }}
                                                </span>
                                            @empty
                                                <span class="text-xs text-gray-400 italic">No role assigned</span>
                                            @endforelse
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span class="font-semibold text-gray-900 block">{{ $user->created_at->format('Y-m-d') }}</span>
                                            <span class="text-xs text-gray-400">{{ $user->created_at->diffForHumans() }}</span>
                                        </td>
                                        @canany(['edit-users', 'update-users', 'delete-users', 'manage-users'])
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end space-x-2">
                                                @canany(['edit-users', 'update-users', 'manage-users'])
                                                <a href="{{ route('admin.users.edit', $user->id) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-50 text-indigo-700 hover:bg-indigo-600 hover:text-white border border-indigo-100 rounded-xl text-xs font-semibold transition duration-150 shadow-2xs">
                                                    <i data-lucide="edit-3" class="w-3.5 h-3.5 mr-1"></i>
                                                    {{ __('Edit') }}
                                                </a>
                                                @endcanany
                                                
                                                @canany(['delete-users', 'manage-users'])
                                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block delete-form" data-confirm-title="Delete User" data-confirm-message="Are you sure you want to delete user '{{ $user->name }}'? This action cannot be undone.">
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
                                        <td colspan="5" class="px-6 py-12 text-center">
                                            <i data-lucide="user-x" class="w-12 h-12 text-gray-300 mx-auto mb-3"></i>
                                            <p class="text-sm font-medium text-gray-500">{{ __('No users found.') }}</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-5">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
