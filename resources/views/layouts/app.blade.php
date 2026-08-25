<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Lucide Icons -->
        <script src="https://unpkg.com/lucide@latest"></script>
    </head>
    <body class="font-sans antialiased h-full">
        <div class="flex h-screen overflow-hidden" x-data="{ mobileSidebarOpen: false }">
            
            <!-- Sidebar for Desktop -->
            <aside class="hidden md:flex md:flex-col md:w-64 md:shrink-0 h-full">
                @include('layouts.sidebar')
            </aside>

            <!-- Sidebar Backdrop & Drawer for Mobile -->
            <div x-show="mobileSidebarOpen" class="md:hidden fixed inset-0 z-40 flex" role="dialog" aria-modal="true" style="display: none;">
                <!-- Backdrop -->
                <div x-show="mobileSidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/80" aria-hidden="true" @click="mobileSidebarOpen = false"></div>

                <!-- Panel -->
                <aside x-show="mobileSidebarOpen" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="relative flex w-full max-w-xs flex-1 flex-col bg-slate-950">
                    <div class="absolute top-0 right-0 -mr-12 pt-2">
                        <button @click="mobileSidebarOpen = false" class="ml-1 flex h-10 w-10 items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                            <span class="sr-only">Close sidebar</span>
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="h-full w-full">
                        @include('layouts.sidebar')
                    </div>
                </aside>
            </div>

            <!-- Content Area -->
            <div class="flex-1 flex flex-col overflow-hidden">
                
                <!-- Top Navbar -->
                <header class="bg-white border-b border-gray-100 h-16 flex items-center justify-between px-4 sm:px-6 lg:px-8">
                    <!-- Mobile Hamburger -->
                    <button @click="mobileSidebarOpen = true" class="md:hidden p-2 text-gray-500 hover:text-gray-700">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div class="flex-1"></div>

                    <!-- User Actions -->
                    <div class="flex items-center space-x-3 sm:space-x-4">
                        <!-- Language Switcher Dropdown -->
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-1.5 border border-gray-200 text-xs font-semibold rounded-xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none transition shadow-sm">
                                    <span class="mr-1.5 text-base">{{ App::getLocale() == 'kh' ? '🇰🇭' : '🇬🇧' }}</span>
                                    <span class="font-medium text-gray-800">{{ App::getLocale() == 'kh' ? 'ភាសាខ្មែរ' : 'English' }}</span>
                                    <svg class="ms-1.5 h-4 w-4 fill-current text-gray-400" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('lang.switch', 'en')" class="flex items-center space-x-2 text-xs font-medium">
                                    <span class="text-base">🇬🇧</span>
                                    <span class="flex-1">English (EN)</span>
                                    @if(App::getLocale() == 'en')
                                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    @endif
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('lang.switch', 'kh')" class="flex items-center space-x-2 text-xs font-medium">
                                    <span class="text-base">🇰🇭</span>
                                    <span class="flex-1">ភាសាខ្មែរ (KH)</span>
                                    @if(App::getLocale() == 'kh')
                                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    @endif
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>

                        <!-- Profile Dropdown -->
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>{{ Auth::user()->name }}</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </header>

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white shadow-sm">
                        <div class=" mx-auto py-4 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="flex-1 overflow-y-auto bg-gray-50 p-4 sm:p-6 lg:p-8">
                    {{ $slot }}
                </main>
            </div>
        </div>
        
        <!-- Toast Alerts -->
        <x-toast />

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (window.lucide) {
                    lucide.createIcons();
                }
            });
        </script>
    </body>
</html>

