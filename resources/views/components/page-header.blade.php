@props([
    'title',
    'description' => null,
    'backUrl' => null,
    'backLabel' => 'Kembali',
])

<div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        @if ($backUrl)
            <a href="{{ $backUrl }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-indigo-600 transition-colors mb-2 group">
                <svg class="h-3.5 w-3.5 transition-transform group-hover:-translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>{{ $backLabel }}</span>
            </a>
        @endif

        <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900">{{ $title }}</h1>
        @if ($description)
            <p class="mt-1 text-sm text-slate-500">{{ $description }}</p>
        @endif
    </div>

    @if (isset($actions))
        <div class="flex flex-wrap items-center gap-2.5">
            {{ $actions }}
        </div>
    @endif
</div>

