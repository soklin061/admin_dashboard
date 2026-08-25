<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.users.index') }}" class="p-2 rounded-xl bg-white border border-gray-200 text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <div>
                    <h2 class="font-bold text-2xl text-gray-900 leading-tight flex items-center gap-2">
                        {{ __('User Profile') }}: <span class="text-indigo-600">{{ $user->name }}</span>
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">{{ __('User account details, assigned roles, and granted permissions.') }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                @canany(['edit users', 'update users', 'manage users'])
                <a href="{{ route('admin.users.edit', $user->id) }}" class="inline-flex items-center px-4 py-2.5 bg-indigo-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-wider hover:bg-indigo-700 active:bg-indigo-800 transition shadow-sm">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    {{ __('Edit User') }}
                </a>
                @endcanany
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- User Header Card -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="flex items-center space-x-4">
                    <div class="h-16 w-16 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-600 text-white font-bold flex items-center justify-center text-xl uppercase shadow-md">
                        {{ substr($user->name, 0, 2) }}
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">{{ $user->name }}</h3>
                        <p class="text-sm font-medium text-gray-500">{{ $user->email }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ __('Joined Date') }}: <span class="font-semibold text-gray-700">{{ $user->created_at->format('Y-m-d H:i:s') }}</span> ({{ $user->created_at->diffForHumans() }})</p>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    @forelse($user->roles as $role)
                        <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-100 shadow-2xs">
                            <span class="w-2 h-2 rounded-full bg-indigo-500 mr-2"></span>
                            {{ $role->name }}
                        </span>
                    @empty
                        <span class="text-xs text-gray-400 italic">No roles assigned</span>
                    @endforelse
                </div>
            </div>

            <!-- Granted Role & Permissions Cards -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="text-base font-bold text-gray-900 mb-6 flex items-center gap-2 border-b border-gray-100 pb-4">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    {{ __('Assigned Roles') }} &amp; {{ __('Granted Permissions') }}
                </h3>

                @forelse($user->roles as $role)
                    <div class="mb-6 bg-slate-50/70 rounded-2xl p-5 border border-gray-200/80">
                        <div class="flex items-center justify-between pb-3 mb-4 border-b border-gray-200/80">
                            <div class="flex items-center space-x-2">
                                <span class="font-bold text-gray-900 text-sm">{{ $role->name }}</span>
                                <span class="text-xs text-gray-400">({{ $role->permissions->count() }} {{ __('Permissions') }})</span>
                            </div>
                            <a href="{{ route('admin.roles.show', $role->id) }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition">
                                {{ __('View Details') }} &rarr;
                            </a>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2.5">
                            @foreach($role->permissions as $perm)
                                <div class="flex items-center px-3 py-2 rounded-xl bg-white text-emerald-800 border border-emerald-200/80 text-xs font-semibold shadow-2xs">
                                    <svg class="w-3.5 h-3.5 mr-1.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    <span class="truncate">{{ $perm->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-gray-400 italic text-center py-6">{{ __('No roles or permissions assigned.') }}</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
