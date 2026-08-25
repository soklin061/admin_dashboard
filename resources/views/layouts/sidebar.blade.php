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
            <i data-lucide="sliders" class="h-6 w-6 text-indigo-500"></i>
            <span>ADMIN PANEL</span>
        </a>
    </div>

    <!-- Search Input -->
    <div class="px-4 py-3 border-b border-slate-900 bg-slate-900/50">
        <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <i data-lucide="search" class="h-4 w-4 text-slate-500"></i>
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
                <i data-lucide="layout-dashboard" class="mr-3 h-5 w-5"></i>
                <span>{{ __('Dashboard') }}</span>
            </a>
        </div>

        @canany(['view-users', 'show-users', 'manage-users', 'view-roles', 'show-roles', 'manage-roles', 'view-permissions', 'show-permissions', 'manage-permissions'])
        <div class="h-px bg-slate-900 my-4" x-show="(
            {{ Auth::user()->can('view-users') || Auth::user()->can('manage-users') ? "match('Users')" : 'false' }} || 
            {{ Auth::user()->can('view-roles') || Auth::user()->can('manage-roles') ? "match('Roles')" : 'false' }} || 
            {{ Auth::user()->can('view-permissions') || Auth::user()->can('manage-permissions') ? "match('Permissions')" : 'false' }}
        )"></div>

        <!-- User Management (Collapsible Group) -->
        <div x-show="(
            {{ Auth::user()->can('view-users') || Auth::user()->can('manage-users') ? "match('Users')" : 'false' }} || 
            {{ Auth::user()->can('view-roles') || Auth::user()->can('manage-roles') ? "match('Roles')" : 'false' }} || 
            {{ Auth::user()->can('view-permissions') || Auth::user()->can('manage-permissions') ? "match('Permissions')" : 'false' }}
        )" class="space-y-1">
            <button @click="openSub.users = !openSub.users" 
                class="flex items-center justify-between w-full px-4 py-2 text-xs font-semibold text-slate-500 uppercase tracking-wider hover:text-slate-300 transition-colors duration-150">
                <span class="flex items-center">
                    <i data-lucide="users" class="mr-2 h-3.5 w-3.5 text-slate-500"></i>
                    <span>{{ __('User Management') }}</span>
                </span>
                <i data-lucide="chevron-right" class="h-3.5 w-3.5 transform transition-transform duration-200" :class="openSub.users ? 'rotate-90' : ''"></i>
            </button>
            
            <div x-show="openSub.users" x-collapse class="space-y-1 pl-2">
                @canany(['view-users', 'show-users', 'manage-users'])
                <a x-show="match('Users')" href="{{ route('admin.users.index') }}" 
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->routeIs('admin.users.*') ? 'bg-slate-900 text-white font-semibold' : 'hover:bg-slate-900 hover:text-white text-slate-400' }}">
                    <span class="mr-3 h-2 w-2 rounded-full {{ request()->routeIs('admin.users.*') ? 'bg-indigo-500' : 'bg-slate-700' }}"></span>
                    <span>{{ __('Users') }}</span>
                </a>
                @endcanany
                
                @canany(['view-roles', 'show-roles', 'manage-roles'])
                <a x-show="match('Roles')" href="{{ route('admin.roles.index') }}" 
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->routeIs('admin.roles.*') ? 'bg-slate-900 text-white font-semibold' : 'hover:bg-slate-900 hover:text-white text-slate-400' }}">
                    <span class="mr-3 h-2 w-2 rounded-full {{ request()->routeIs('admin.roles.*') ? 'bg-indigo-500' : 'bg-slate-700' }}"></span>
                    <span>{{ __('Roles') }}</span>
                </a>
                @endcanany
                
                @canany(['view-permissions', 'show-permissions', 'manage-permissions'])
                <a x-show="match('Permissions')" href="{{ route('admin.permissions.index') }}" 
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->routeIs('admin.permissions.*') ? 'bg-slate-900 text-white font-semibold' : 'hover:bg-slate-900 hover:text-white text-slate-400' }}">
                    <span class="mr-3 h-2 w-2 rounded-full {{ request()->routeIs('admin.permissions.*') ? 'bg-indigo-500' : 'bg-slate-700' }}"></span>
                    <span>{{ __('Permissions') }}</span>
                </a>
                @endcanany
            </div>
        </div>
        @endcanany

        <div class="h-px bg-slate-900 my-4" x-show="(
            {{ Auth::user()->can('view-settings') || Auth::user()->can('manage-settings') ? "match('Settings')" : 'false' }} || 
            match('Notifications') || 
            {{ Auth::user()->can('view-logs') || Auth::user()->can('show-logs') ? "match('Activity Logs')" : 'false' }}
        )"></div>

        <!-- System & Logs (Collapsible Group) -->
        <div x-show="(
            {{ Auth::user()->can('view-settings') || Auth::user()->can('manage-settings') ? "match('Settings')" : 'false' }} || 
            match('Notifications') || 
            {{ Auth::user()->can('view-logs') || Auth::user()->can('show-logs') ? "match('Activity Logs')" : 'false' }}
        )" class="space-y-1">
            <button @click="openSub.system = !openSub.system" 
                class="flex items-center justify-between w-full px-4 py-2 text-xs font-semibold text-slate-500 uppercase tracking-wider hover:text-slate-300 transition-colors duration-150">
                <span class="flex items-center">
                    <i data-lucide="shield" class="mr-2 h-3.5 w-3.5 text-slate-500"></i>
                    <span>{{ __('System & Audits') }}</span>
                </span>
                <i data-lucide="chevron-right" class="h-3.5 w-3.5 transform transition-transform duration-200" :class="openSub.system ? 'rotate-90' : ''"></i>
            </button>
            
            <div x-show="openSub.system" x-collapse class="space-y-1 pl-2">
                @canany(['view-settings', 'edit-settings', 'manage-settings'])
                <a x-show="match('Settings')" href="{{ route('admin.settings.edit') }}" 
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->routeIs('admin.settings.*') ? 'bg-slate-900 text-white font-semibold' : 'hover:bg-slate-900 hover:text-white text-slate-400' }}">
                    <span class="mr-3 h-2 w-2 rounded-full {{ request()->routeIs('admin.settings.*') ? 'bg-indigo-500' : 'bg-slate-700' }}"></span>
                    <span>{{ __('Settings') }}</span>
                </a>
                @endcanany
                
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
                
                @canany(['view-logs', 'show-logs'])
                <a x-show="match('Activity Logs')" href="{{ route('admin.activity-logs.index') }}" 
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->routeIs('admin.activity-logs.*') ? 'bg-slate-900 text-white font-semibold' : 'hover:bg-slate-900 hover:text-white text-slate-400' }}">
                    <span class="mr-3 h-2 w-2 rounded-full {{ request()->routeIs('admin.activity-logs.*') ? 'bg-indigo-500' : 'bg-slate-700' }}"></span>
                    <span>{{ __('Activity Logs') }}</span>
                </a>
                @endcanany
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
