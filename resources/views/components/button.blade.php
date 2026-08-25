@props([
    'variant' => 'primary',
    'type' => 'submit'
])

@php
    $baseClasses = 'inline-flex items-center px-4 py-2 border rounded-md font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm disabled:opacity-25';
    
    $variants = [
        'primary' => 'bg-indigo-600 border-transparent text-white hover:bg-indigo-700 active:bg-indigo-900 focus:ring-indigo-500',
        'secondary' => 'bg-white border-gray-300 text-gray-700 hover:bg-gray-50 focus:ring-indigo-500',
        'danger' => 'bg-red-600 border-transparent text-white hover:bg-red-700 active:bg-red-900 focus:ring-red-500',
        'success' => 'bg-emerald-600 border-transparent text-white hover:bg-emerald-700 active:bg-emerald-900 focus:ring-emerald-500',
        'warning' => 'bg-amber-500 border-transparent text-white hover:bg-amber-600 active:bg-amber-700 focus:ring-amber-500',
        'info' => 'bg-sky-500 border-transparent text-white hover:bg-sky-600 active:bg-sky-700 focus:ring-sky-500',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>
