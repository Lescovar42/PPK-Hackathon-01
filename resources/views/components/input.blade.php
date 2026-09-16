@props([
    'name',
    'label' => null,
    'type' => 'text',
    'value' => null,
    'placeholder' => '',
    'required' => false,
    'hint' => null,
])

@php
    $hasError = $errors->has($name);
    $id = $attributes->get('id', $name);
    $inputValue = old($name, $value ?? '');
@endphp

<div class="w-full">
    @if ($label)
        <label for="{{ $id }}" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
            {{ $label }}
            @if ($required)
                <span class="text-rose-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $id }}"
            value="{{ $inputValue }}"
            placeholder="{{ $placeholder }}"
            @if ($required) required @endif
            {{ $attributes->merge([
                'class' => 'w-full rounded-xl border bg-white px-3.5 py-2.5 text-sm text-slate-800 placeholder-slate-400 shadow-2xs transition-all focus:outline-none focus:ring-2 ' .
                ($hasError
                    ? 'border-rose-300 focus:border-rose-500 focus:ring-rose-200'
                    : 'border-slate-200 focus:border-indigo-500 focus:ring-indigo-100')
            ]) }}
        >
    </div>

    @if ($hint && !$hasError)
        <p class="mt-1 text-xs text-slate-500">{{ $hint }}</p>
    @endif

    @error($name)
        <p class="mt-1.5 text-xs font-medium text-rose-600 flex items-center gap-1">
            <svg class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ $message }}</span>
        </p>
    @enderror
</div>

