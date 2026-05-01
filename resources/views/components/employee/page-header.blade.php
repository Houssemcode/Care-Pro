@props(['title', 'subtitle' => '', 'breadcrumb' => ''])

<div class="flex flex-col lg:flex-row justify-between lg:items-end gap-4 sm:gap-6 mb-8">
    <div>
        @if($breadcrumb)
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">{{ $breadcrumb }}</p>
        @endif
        <h1 class="text-3xl sm:text-4xl font-display font-extrabold text-slate-900 mb-1 sm:mb-2">{{ $title }}</h1>
        @if($subtitle)
            <p class="text-sm sm:text-base text-slate-500 font-medium">{{ $subtitle }}</p>
        @endif
    </div>
    {{ $actions ?? '' }}
</div>
