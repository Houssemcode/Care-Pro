@props(['label', 'value', 'icon', 'color' => 'brand', 'suffix' => ''])

@php
    $colors = [
        'brand'   => 'bg-brand-100 text-brand-600 bg-brand-50',
        'emerald' => 'bg-emerald-100 text-emerald-600 bg-emerald-50',
        'amber'   => 'bg-amber-100 text-amber-600 bg-amber-50',
        'indigo'  => 'bg-indigo-100 text-indigo-600 bg-indigo-50',
        'rose'    => 'bg-rose-100 text-rose-600 bg-rose-50',
    ];
    $colorClass = $colors[$color] ?? $colors['brand'];
    $iconBg = explode(' ', $colorClass)[0];
    $iconText = explode(' ', $colorClass)[1];
    $blurBg = explode(' ', $colorClass)[2];
@endphp

<div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] flex flex-col relative overflow-hidden group">
    <div class="absolute -right-4 -top-4 w-24 h-24 {{ $blurBg }} rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
    <div class="w-10 h-10 rounded-xl {{ $iconBg }} {{ $iconText }} flex items-center justify-center mb-4 relative z-10">
        {!! $icon !!}
    </div>
    <p class="text-slate-500 font-semibold text-xs uppercase tracking-wider mb-1 relative z-10">{{ $label }}</p>
    <div class="flex items-baseline gap-2 relative z-10">
        <h3 class="text-3xl font-display font-extrabold text-slate-900">{{ $value }}</h3>
        @if($suffix)
            <span class="text-sm font-bold {{ $iconText }}">{{ $suffix }}</span>
        @endif
    </div>
</div>
