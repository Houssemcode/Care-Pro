@props(['title' => ''])

<div class="lg:hidden flex items-center justify-between bg-white px-5 py-4 rounded-2xl shadow-sm border border-slate-100 mb-6">
    <button onclick="toggleSidebar()" class="p-2 -ml-2 rounded-lg hover:bg-slate-100 text-slate-600 transition-colors">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>
    <span class="font-display font-bold text-slate-800">{{ $title }}</span>
    <a href="{{ route('admin.profile') }}" class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-xs shadow-md">
        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
    </a>
</div>
