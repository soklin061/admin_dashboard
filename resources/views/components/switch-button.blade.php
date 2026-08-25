@props([
    'name',
    'checked' => false,
    'value' => '1',
    'label' => null,
    'disabled' => false
])

<label class="inline-flex items-center cursor-pointer select-none">
    <div class="relative">
        <input type="checkbox" name="{{ $name }}" value="{{ $value }}" {{ $checked ? 'checked' : '' }} {{ $disabled ? 'disabled' : '' }}
            {{ $attributes->merge(['class' => 'sr-only peer']) }}>
        
        <!-- Track -->
        <div class="w-10 h-6 bg-gray-200 border border-gray-300 rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-500/20 peer-checked:bg-indigo-600 transition-colors duration-200"></div>
        
        <!-- Thumb -->
        <div class="absolute left-1 top-1 bg-white border border-gray-300 w-4 h-4 rounded-full transition-transform duration-200 peer-checked:translate-x-full peer-checked:border-white"></div>
    </div>
    
    @if($label)
        <span class="ms-3 text-sm font-medium text-gray-700">{{ $label }}</span>
    @endif
</label>
