@props([
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
    'type' => 'submit',
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-medium transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer';

    $sizeClasses = match ($size) {
        'xs' => 'px-2.5 py-1 text-xs rounded-md gap-1',
        'sm' => 'px-3 py-1.5 text-xs sm:text-sm rounded-lg gap-1.5',
        'lg' => 'px-6 py-3 text-base rounded-xl gap-2 font-semibold shadow-md',
        default => 'px-4 py-2 text-sm rounded-xl gap-2 shadow-xs',
    };

    $variantClasses = match ($variant) {
        'secondary' => 'bg-white hover:bg-slate-50 text-slate-700 border border-slate-300 focus:ring-slate-400',
        'outline' => 'bg-transparent hover:bg-indigo-50 text-indigo-600 border border-indigo-200 focus:ring-indigo-500',
        'danger' => 'bg-rose-600 hover:bg-rose-700 text-white focus:ring-rose-500 shadow-rose-600/20',
        'success' => 'bg-emerald-600 hover:bg-emerald-700 text-white focus:ring-emerald-500 shadow-emerald-600/20',
        'ghost' => 'bg-transparent hover:bg-slate-100 text-slate-600 hover:text-slate-900 focus:ring-slate-400 shadow-none',
        default => 'bg-indigo-600 hover:bg-indigo-700 text-white focus:ring-indigo-500 shadow-indigo-600/20',
    };

    $classes = "{$baseClasses} {$sizeClasses} {$variantClasses}";
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif

