@props(['title', 'subtitle' => '', 'breadcrumb' => ''])

<header class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 pb-6 border-b border-slate-200 gap-4">
    <div>
        @if($breadcrumb)
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">{{ $breadcrumb }}</p>
        @endif
        <h1 class="text-2xl sm:text-3xl font-display font-extrabold text-slate-900 tracking-tight">{{ $title }}</h1>
        @if($subtitle)
            <p class="text-slate-500 text-sm font-medium mt-1">{{ $subtitle }}</p>
        @endif
    </div>
</header>
