@props(['label', 'value', 'icon', 'color' => 'brand', 'trend' => null])

<div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgba(0,0,0,0.08)] transition-all duration-300 group">
    <div class="flex justify-between items-start mb-4">
        <div class="w-12 h-12 rounded-2xl bg-{{ $color }}-50 text-{{ $color }}-600 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
            {!! $icon !!}
        </div>
        @if($trend)
            <span class="flex items-center gap-1 text-[10px] font-bold px-2 py-1 rounded-lg {{ $trend > 0 ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $trend > 0 ? 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6' : 'M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6' }}"></path></svg>
                {{ abs($trend) }}%
            </span>
        @endif
    </div>
    <div>
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">{{ $label }}</p>
        <h3 class="text-2xl sm:text-3xl font-display font-black text-slate-900 tracking-tight">{{ $value }}</h3>
    </div>
</div>
