<div class="overflow-hidden rounded-xl border border-slate-200/80 bg-white shadow-2xs">
    <div class="overflow-x-auto">
        <table {{ $attributes->merge(['class' => 'min-w-full divide-y divide-slate-200 text-left text-sm']) }}>
            {{ $slot }}
        </table>
    </div>
</div>

