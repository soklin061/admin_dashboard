<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Dashboard') }}
                </h2>
                <p class="text-xs text-gray-500 mt-1">Overview of system metrics, activities, and administrative shortcuts.</p>
            </div>
            <div class="flex items-center space-x-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200">
                    <span class="w-2 h-2 mr-1.5 bg-emerald-500 rounded-full animate-pulse"></span> System Operational
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class=" mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Summary Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-5">
                <!-- Users Card -->
                @can('manage-users')
                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between group">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ __('Users') }}</span>
                        <div class="p-2.5 rounded-xl bg-indigo-50 text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition">
                            <i data-lucide="users" class="w-5 h-5"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ $usersCount }}</div>
                        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center text-xs font-semibold text-indigo-600 hover:text-indigo-800 mt-2 group-hover:translate-x-1 transition">
                            {{ __('Manage Users') }} <i data-lucide="chevron-right" class="w-3.5 h-3.5 ml-1"></i>
                        </a>
                    </div>
                </div>
                @endcan

                <!-- Roles Card -->
                @can('manage-roles')
                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between group">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ __('Roles') }}</span>
                        <div class="p-2.5 rounded-xl bg-purple-50 text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition">
                            <i data-lucide="shield" class="w-5 h-5"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ $rolesCount }}</div>
                        <a href="{{ route('admin.roles.index') }}" class="inline-flex items-center text-xs font-semibold text-purple-600 hover:text-purple-800 mt-2 group-hover:translate-x-1 transition">
                            {{ __('Manage Roles') }} <i data-lucide="chevron-right" class="w-3.5 h-3.5 ml-1"></i>
                        </a>
                    </div>
                </div>
                @endcan

                <!-- Permissions Card -->
                @can('manage-permissions')
                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between group">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ __('Permissions') }}</span>
                        <div class="p-2.5 rounded-xl bg-blue-50 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition">
                            <i data-lucide="key" class="w-5 h-5"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ $permissionsCount }}</div>
                        <a href="{{ route('admin.permissions.index') }}" class="inline-flex items-center text-xs font-semibold text-blue-600 hover:text-blue-800 mt-2 group-hover:translate-x-1 transition">
                            {{ __('View Permissions') }} <i data-lucide="chevron-right" class="w-3.5 h-3.5 ml-1"></i>
                        </a>
                    </div>
                </div>
                @endcan

                <!-- Unread Alerts Card -->
                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between group">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ __('Unread Alerts') }}</span>
                        <div class="p-2.5 rounded-xl bg-amber-50 text-amber-600 group-hover:bg-amber-500 group-hover:text-white transition">
                            <i data-lucide="bell" class="w-5 h-5"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ $unreadNotificationsCount }}</div>
                        <a href="{{ route('admin.notifications.index') }}" class="inline-flex items-center text-xs font-semibold text-amber-600 hover:text-amber-800 mt-2 group-hover:translate-x-1 transition">
                            {{ __('Notifications') }} <i data-lucide="chevron-right" class="w-3.5 h-3.5 ml-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Settings Card -->
                @can('manage-settings')
                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between group">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ __('Settings') }}</span>
                        <div class="p-2.5 rounded-xl bg-emerald-50 text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition">
                            <i data-lucide="settings" class="w-5 h-5"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ $settingsCount }}</div>
                        <a href="{{ route('admin.settings.edit') }}" class="inline-flex items-center text-xs font-semibold text-emerald-600 hover:text-emerald-800 mt-2 group-hover:translate-x-1 transition">
                            {{ __('Edit System Settings') }} <i data-lucide="chevron-right" class="w-3.5 h-3.5 ml-1"></i>
                        </a>
                    </div>
                </div>
                @endcan

                <!-- Activity Log Card -->
                @can('view-logs')
                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between group">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ __('Total Logs') }}</span>
                        <div class="p-2.5 rounded-xl bg-slate-100 text-slate-600 group-hover:bg-slate-800 group-hover:text-white transition">
                            <i data-lucide="file-text" class="w-5 h-5"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ $activityLogsCount }}</div>
                        <a href="{{ route('admin.activity-logs.index') }}" class="inline-flex items-center text-xs font-semibold text-slate-600 hover:text-slate-900 mt-2 group-hover:translate-x-1 transition">
                            {{ __('View Activity Logs') }} <i data-lucide="chevron-right" class="w-3.5 h-3.5 ml-1"></i>
                        </a>
                    </div>
                </div>
                @endcan
            </div>

            <!-- Recent Activity Table -->
            @can('view-logs')
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-slate-50/50">
                    <div>
                        <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ __('Recent Activity Logs') }}
                        </h3>
                        <p class="text-xs text-gray-500 mt-0.5">Real-time trail of recent actions recorded by the system.</p>
                    </div>
                    <a href="{{ route('admin.activity-logs.index') }}" class="inline-flex items-center px-3.5 py-1.5 bg-white border border-gray-200 rounded-xl text-xs font-semibold text-gray-700 hover:bg-gray-50 hover:text-indigo-600 transition shadow-sm">
                        {{ __('View All Activity Logs') }}
                        <svg class="w-3.5 h-3.5 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>

                <div class="p-6">
                    @if($recentActivities->isEmpty())
                        <div class="text-center py-10">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <p class="text-sm font-medium text-gray-500">{{ __('No recent activities logged.') }}</p>
                        </div>
                    @else
                        <div class="overflow-x-auto rounded-2xl border border-gray-200/80">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-slate-50/80 border-b border-gray-200">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('User / Causer') }}</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Event') }}</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Activity Description') }}</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Date & Time') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @foreach($recentActivities as $activity)
                                        <tr class="hover:bg-slate-50/70 transition-colors duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-600 text-white font-bold flex items-center justify-center text-xs uppercase shadow-sm">
                                                        {{ substr($activity->causer ? $activity->causer->name : 'S', 0, 2) }}
                                                    </div>
                                                    <div class="ml-3">
                                                        <div class="text-sm font-bold text-gray-900">
                                                            {{ $activity->causer ? $activity->causer->name : __('System / Guest') }}
                                                        </div>
                                                        @if($activity->causer)
                                                            <div class="text-xs text-gray-400">
                                                                {{ $activity->causer->email }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $event = strtolower($activity->event ?? 'log');
                                                    $color = match($event) {
                                                        'created' => 'bg-emerald-50 text-emerald-700 border-emerald-200/80',
                                                        'updated' => 'bg-sky-50 text-sky-700 border-sky-200/80',
                                                        'deleted' => 'bg-rose-50 text-rose-700 border-rose-200/80',
                                                        default => 'bg-slate-100 text-slate-700 border-slate-200/80'
                                                    };
                                                @endphp
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border shadow-2xs {{ $color }}">
                                                    {{ ucfirst($event) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-700 font-medium">
                                                {{ $activity->description }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <span class="font-semibold text-gray-900 block">{{ $activity->created_at->diffForHumans() }}</span>
                                                <span class="text-xs text-gray-400 mt-0.5">{{ $activity->created_at->format('Y-m-d H:i') }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
            @endcan
        </div>
    </div>
</x-app-layout>

