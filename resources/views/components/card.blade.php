@props([
    'title' => null,
    'subtitle' => null,
    'padding' => 'p-6',
])

<div {{ $attributes->merge(['class' => 'bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden transition-all']) }}>
    @if ($title || isset($header) || isset($actions))
        <div class="px-6 py-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-slate-50/50">
            @if (isset($header))
                {{ $header }}
            @else
                <div>
                    @if ($title)
                        <h3 class="text-base font-semibold text-slate-900 leading-6">{{ $title }}</h3>
                    @endif
                    @if ($subtitle)
                        <p class="text-xs text-slate-500 mt-0.5">{{ $subtitle }}</p>
                    @endif
                </div>
            @endif

            @if (isset($actions))
                <div class="flex items-center gap-2 shrink-0">
                    {{ $actions }}
                </div>
            @endif
        </div>
    @endif

    <div class="{{ $padding }}">
        {{ $slot }}
    </div>

    @if (isset($footer))
        <div class="px-6 py-3.5 bg-slate-50 border-t border-slate-100 text-xs text-slate-500 flex items-center justify-between">
            {{ $footer }}
        </div>
    @endif
</div>

