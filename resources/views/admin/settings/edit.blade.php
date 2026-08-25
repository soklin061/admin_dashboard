<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Site Name -->
                        <div class="mb-4">
                            <label for="site_name" class="block text-sm font-medium text-gray-700">{{ __('Site Name') }}</label>
                            <input type="text" name="site_name" id="site_name" value="{{ $settings['site_name'] ?? '' }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Site Email -->
                        <div class="mb-4">
                            <label for="site_email" class="block text-sm font-medium text-gray-700">{{ __('Site Email') }}</label>
                            <input type="email" name="site_email" id="site_email" value="{{ $settings['site_email'] ?? '' }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Maintenance Mode -->
                        <div class="mb-4">
                            <label for="maintenance_mode" class="block text-sm font-medium text-gray-700">{{ __('Maintenance Mode') }}</label>
                            <select name="maintenance_mode" id="maintenance_mode" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="no" @selected(($settings['maintenance_mode'] ?? 'no') === 'no')>{{ __('No (Live)') }}</option>
                                <option value="yes" @selected(($settings['maintenance_mode'] ?? 'no') === 'yes')>{{ __('Yes (Down for Maintenance)') }}</option>
                            </select>
                        </div>

                        <!-- Allowed Registration -->
                        <div class="mb-6">
                            <label for="allowed_registration" class="block text-sm font-medium text-gray-700">{{ __('Allow Public Registration') }}</label>
                            <select name="allowed_registration" id="allowed_registration" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="yes" @selected(($settings['allowed_registration'] ?? 'yes') === 'yes')>{{ __('Yes') }}</option>
                                <option value="no" @selected(($settings['allowed_registration'] ?? 'yes') === 'no')>{{ __('No') }}</option>
                            </select>
                        </div>

                        @canany(['edit-settings', 'update-settings', 'manage-settings'])
                        <div class="flex items-center justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Save Settings') }}
                            </button>
                        </div>
                        @endcanany
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
