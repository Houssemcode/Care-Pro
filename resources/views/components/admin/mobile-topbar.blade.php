@props(['title' => ''])

<div class="lg:hidden flex items-center justify-between bg-white px-5 py-4 rounded-2xl shadow-sm border border-slate-100 mb-6">
    <button onclick="toggleSidebar()" class="p-2 -ms-2 rounded-lg hover:bg-slate-100 text-slate-600 transition-colors">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>
    <span class="font-display font-bold text-slate-800">{{ $title }}</span>
    <div class="flex items-center gap-2">
        {{-- Mobile Language Switcher --}}
        <a href="{{ route('lang.switch', app()->getLocale() === 'en' ? 'ar' : 'en') }}"
           class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-brand-50 text-slate-600 hover:text-brand-600 transition-all text-xs font-bold"
           title="{{ app()->getLocale() === 'en' ? 'العربية' : 'English' }}">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
            {{ app()->getLocale() === 'en' ? 'AR' : 'EN' }}
        </a>
        <a href="{{ route('admin.profile') }}" class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-xs shadow-md">
            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
        </a>
    </div>
</div>
