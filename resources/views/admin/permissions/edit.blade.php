<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.permissions.index') }}" class="p-2 rounded-xl bg-white border border-gray-200 text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition shadow-sm flex items-center justify-center">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </a>
                <div>
                    <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                        {{ __('Edit Permission') }}: <span class="text-indigo-600">{{ $permission->name }}</span>
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">{{ __('Update system permission key name.') }}</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <form action="{{ route('admin.permissions.update', $permission->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">{{ __('Permission Key Name') }}</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $permission->name) }}" required placeholder="e.g. view-users, edit-posts" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 text-sm py-2.5 px-3">
                        @error('name')
                            <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">{{ __('Guard Name') }}</label>
                        <input type="text" value="{{ $permission->guard_name }}" disabled class="w-full rounded-xl border-gray-200 bg-gray-50 text-gray-500 text-sm py-2.5 px-3 cursor-not-allowed">
                    </div>

                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('admin.permissions.index') }}" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-xs font-bold transition">
                            {{ __('Cancel') }}
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-sm transition">
                            <i data-lucide="check" class="w-4 h-4 mr-1.5"></i>
                            {{ __('Update Permission') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
