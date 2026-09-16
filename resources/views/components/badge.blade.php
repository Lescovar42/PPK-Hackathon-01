@props([
    'variant' => 'neutral',
    'size' => 'md',
    'dot' => false,
])

@php
    $baseClasses = 'inline-flex items-center font-medium rounded-full';

    $sizeClasses = match ($size) {
        'sm' => 'px-2 py-0.5 text-[11px] gap-1',
        default => 'px-2.5 py-1 text-xs gap-1.5',
    };

    $variantClasses = match ($variant) {
        'success' => 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20',
        'warning' => 'bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20',
        'danger' => 'bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/20',
        'info' => 'bg-indigo-50 text-indigo-700 ring-1 ring-inset ring-indigo-600/20',
        default => 'bg-slate-100 text-slate-700 ring-1 ring-inset ring-slate-500/10',
    };

    $dotClasses = match ($variant) {
        'success' => 'bg-emerald-500',
        'warning' => 'bg-amber-500',
        'danger' => 'bg-rose-500',
        'info' => 'bg-indigo-500',
        default => 'bg-slate-400',
    };
@endphp

<span {{ $attributes->merge(['class' => "{$baseClasses} {$sizeClasses} {$variantClasses}"]) }}>
    @if ($dot)
        <span class="h-1.5 w-1.5 rounded-full {{ $dotClasses }}"></span>
    @endif
    {{ $slot }}
</span>

