<div x-data="{ 
    search: '', 
    openSub: { 
        users: {{ request()->routeIs('admin.users.*', 'admin.roles.*', 'admin.permissions.*') ? 'true' : 'false' }}, 
        system: {{ request()->routeIs('admin.settings.*', 'admin.notifications.*', 'admin.activity-logs.*') ? 'true' : 'false' }} 
    },
    match(text) {
        return !this.search || text.toLowerCase().includes(this.search.toLowerCase());
    }
}" class="flex flex-col h-full bg-slate-950 text-slate-300">
    <!-- Brand / Logo -->
    <div class="flex items-center justify-between h-16 px-6 bg-slate-900 border-b border-slate-800">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2 font-bold text-white text-lg tracking-wider">
            <svg class="h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
            </svg>
            <span>ADMIN PANEL</span>
        </a>
    </div>

    <!-- Search Input -->
    <div class="px-4 py-3 border-b border-slate-900 bg-slate-900/50">
        <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input x-model="search" type="text" placeholder="Search menu..." 
                class="w-full bg-slate-800 text-slate-200 placeholder-slate-500 text-xs border-0 rounded-lg focus:ring-1 focus:ring-indigo-500 pl-9 py-2">
        </div>
    </div>

    <!-- Nav Items -->
    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
        
        <!-- Dashboard (Standalone) -->
        <div x-show="match('Dashboard')">
            <a href="{{ route('admin.dashboard') }}" 
                class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white font-semibold' : 'hover:bg-slate-900 hover:text-white text-slate-300' }}">
                <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span>{{ __('Dashboard') }}</span>
            </a>
        </div>

        <div class="h-px bg-slate-900 my-4" x-show="match('Users') || match('Roles') || match('Permissions') || match('Settings') || match('Notifications') || match('Activity Logs')"></div>

        <!-- User Management (Collapsible Group) -->
        <div x-show="match('Users') || match('Roles') || match('Permissions')" class="space-y-1">
            <button @click="openSub.users = !openSub.users" 
                class="flex items-center justify-between w-full px-4 py-2 text-xs font-semibold text-slate-500 uppercase tracking-wider hover:text-slate-300 transition-colors duration-150">
                <span>{{ __('User Management') }}</span>
                <svg class="h-3 w-3 transform transition-transform duration-200" :class="openSub.users ? 'rotate-90' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
            
            <div x-show="openSub.users" x-collapse class="space-y-1 pl-2">
                <a x-show="match('Users')" href="{{ route('admin.users.index') }}" 
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->routeIs('admin.users.*') ? 'bg-slate-900 text-white font-semibold' : 'hover:bg-slate-900 hover:text-white text-slate-400' }}">
                    <span class="mr-3 h-2 w-2 rounded-full {{ request()->routeIs('admin.users.*') ? 'bg-indigo-500' : 'bg-slate-700' }}"></span>
                    <span>{{ __('Users') }}</span>
                </a>
                
                <a x-show="match('Roles')" href="{{ route('admin.roles.index') }}" 
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->routeIs('admin.roles.*') ? 'bg-slate-900 text-white font-semibold' : 'hover:bg-slate-900 hover:text-white text-slate-400' }}">
                    <span class="mr-3 h-2 w-2 rounded-full {{ request()->routeIs('admin.roles.*') ? 'bg-indigo-500' : 'bg-slate-700' }}"></span>
                    <span>{{ __('Roles') }}</span>
                </a>
                
                <a x-show="match('Permissions')" href="{{ route('admin.permissions.index') }}" 
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->routeIs('admin.permissions.*') ? 'bg-slate-900 text-white font-semibold' : 'hover:bg-slate-900 hover:text-white text-slate-400' }}">
                    <span class="mr-3 h-2 w-2 rounded-full {{ request()->routeIs('admin.permissions.*') ? 'bg-indigo-500' : 'bg-slate-700' }}"></span>
                    <span>{{ __('Permissions') }}</span>
                </a>
            </div>
        </div>

        <div class="h-px bg-slate-900 my-4" x-show="match('Settings') || match('Notifications') || match('Activity Logs')"></div>

        <!-- System & Logs (Collapsible Group) -->
        <div x-show="match('Settings') || match('Notifications') || match('Activity Logs')" class="space-y-1">
            <button @click="openSub.system = !openSub.system" 
                class="flex items-center justify-between w-full px-4 py-2 text-xs font-semibold text-slate-500 uppercase tracking-wider hover:text-slate-300 transition-colors duration-150">
                <span>{{ __('System & Audits') }}</span>
                <svg class="h-3 w-3 transform transition-transform duration-200" :class="openSub.system ? 'rotate-90' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
            
            <div x-show="openSub.system" x-collapse class="space-y-1 pl-2">
                <a x-show="match('Settings')" href="{{ route('admin.settings.edit') }}" 
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->routeIs('admin.settings.*') ? 'bg-slate-900 text-white font-semibold' : 'hover:bg-slate-900 hover:text-white text-slate-400' }}">
                    <span class="mr-3 h-2 w-2 rounded-full {{ request()->routeIs('admin.settings.*') ? 'bg-indigo-500' : 'bg-slate-700' }}"></span>
                    <span>{{ __('Settings') }}</span>
                </a>
                
                <a x-show="match('Notifications')" href="{{ route('admin.notifications.index') }}" 
                    class="flex items-center justify-between px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->routeIs('admin.notifications.*') ? 'bg-slate-900 text-white font-semibold' : 'hover:bg-slate-900 hover:text-white text-slate-400' }}">
                    <span class="flex items-center">
                        <span class="mr-3 h-2 w-2 rounded-full {{ request()->routeIs('admin.notifications.*') ? 'bg-indigo-500' : 'bg-slate-700' }}"></span>
                        <span>{{ __('Notifications') }}</span>
                    </span>
                    @if(Auth::user()->unreadNotifications->count() > 0)
                        <span class="px-2 py-0.5 text-xs font-semibold text-white bg-red-500 rounded-full">
                            {{ Auth::user()->unreadNotifications->count() }}
                        </span>
                    @endif
                </a>
                
                <a x-show="match('Activity Logs')" href="{{ route('admin.activity-logs.index') }}" 
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->routeIs('admin.activity-logs.*') ? 'bg-slate-900 text-white font-semibold' : 'hover:bg-slate-900 hover:text-white text-slate-400' }}">
                    <span class="mr-3 h-2 w-2 rounded-full {{ request()->routeIs('admin.activity-logs.*') ? 'bg-indigo-500' : 'bg-slate-700' }}"></span>
                    <span>{{ __('Activity Logs') }}</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- User Section Bottom -->
    <div class="p-4 bg-slate-900 border-t border-slate-800">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="h-9 w-9 rounded-full bg-slate-800 flex items-center justify-center text-white font-bold text-sm tracking-wider">
                    {{ substr(Auth::user()->name, 0, 2) }}
                </div>
            </div>
            <div class="ml-3 overflow-hidden">
                <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-slate-500 truncate">{{ Auth::user()->email }}</p>
            </div>
        </div>
    </div>
</div>
