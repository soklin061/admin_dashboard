@props([
    'options' => [],
    'name',
    'value' => '',
    'placeholder' => 'Select an option'
])

@php
    // Normalize options to standard array of [value, label]
    $normalizedOptions = [];
    foreach($options as $val => $label) {
        if (is_array($label)) {
            $normalizedOptions[] = [
                'value' => $label['value'] ?? $val,
                'label' => $label['label'] ?? $label['value'] ?? $val
            ];
        } else {
            $normalizedOptions[] = [
                'value' => $val,
                'label' => $label
            ];
        }
    }
@endphp

<div x-data="{
    open: false,
    search: '',
    value: @js($value),
    label: '',
    options: @js($normalizedOptions),
    init() {
        let selected = this.options.find(opt => opt.value == this.value);
        if (selected) {
            this.label = selected.label;
        }
    },
    select(opt) {
        this.value = opt.value;
        this.label = opt.label;
        this.open = false;
        this.search = '';
    },
    get filteredOptions() {
        if (!this.search) return this.options;
        return this.options.filter(opt => opt.label.toLowerCase().includes(this.search.toLowerCase()));
    }
}" class="relative w-full" @click.outside="open = false">
    <!-- Hidden input to submit form value -->
    <input type="hidden" name="{{ $name }}" :value="value">

    <!-- Selected box -->
    <button type="button" @click="open = !open" 
        class="w-full flex items-center justify-between bg-white border border-gray-300 rounded-md shadow-sm px-3 py-2 text-left text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
        <span x-text="label || '{{ $placeholder }}'" :class="label ? 'text-gray-900' : 'text-gray-400'"></span>
        <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="none" stroke="currentColor">
            <path d="M7 7l3-3 3 3m0 6l-3 3-3-3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </button>

    <!-- Dropdown list -->
    <div x-show="open" x-transition class="absolute z-50 mt-1 w-full bg-white shadow-lg rounded-md border border-gray-200 py-1" style="display: none;">
        <!-- Search bar inside dropdown -->
        <div class="px-2 py-1.5 border-b border-gray-100">
            <input x-model="search" type="text" placeholder="Search..." 
                class="w-full text-xs px-2.5 py-1.5 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-indigo-500">
        </div>

        <ul class="max-h-60 overflow-y-auto py-1">
            <template x-for="opt in filteredOptions" :key="opt.value">
                <li>
                    <button type="button" @click="select(opt)" 
                        class="w-full text-left px-3 py-2 text-sm hover:bg-indigo-50 transition-colors"
                        :class="value == opt.value ? 'bg-indigo-100/60 font-semibold text-indigo-700' : 'text-gray-700'">
                        <span x-text="opt.label"></span>
                    </button>
                </li>
            </template>
            <li x-show="filteredOptions.length === 0" class="px-3 py-2 text-xs text-gray-400 italic">
                No results found
            </li>
        </ul>
    </div>
</div>
