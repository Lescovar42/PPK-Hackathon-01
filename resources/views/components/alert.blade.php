@props([
    'type' => null,
    'message' => null,
])

@if (session('success') || ($type === 'success' && $message))
    <div {{ $attributes->merge(['class' => 'mb-6 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50/90 p-4 text-emerald-900 shadow-2xs']) }}>
        <div class="rounded-lg bg-emerald-100 p-1 text-emerald-600">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <div class="flex-1 text-sm font-medium pt-0.5">
            {{ session('success') ?? $message }}
        </div>
    </div>
@endif

@if ($errors->any())
    <div {{ $attributes->merge(['class' => 'mb-6 rounded-xl border border-rose-200 bg-rose-50/90 p-4 text-rose-900 shadow-2xs']) }}>
        <div class="flex items-start gap-3">
            <div class="rounded-lg bg-rose-100 p-1 text-rose-600">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div class="flex-1">
                <h4 class="text-sm font-semibold text-rose-800">Terdapat kesalahan input:</h4>
                <ul class="mt-1.5 list-disc list-inside text-xs text-rose-700 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif

