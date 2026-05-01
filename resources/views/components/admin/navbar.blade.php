@props(['active' => 'dashboard'])

<!-- Mobile Nav Overlay -->
<div id="mobile-overlay"
    class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 lg:hidden opacity-0 invisible transition-all duration-300"
    onclick="toggleSidebar()"></div>

<div class="flex">
    <!-- ════════════ SIDEBAR ════════════ -->
    <aside id="sidebar" class="sidebar">
        <div class="p-5 border-b border-white/5 flex items-center justify-between">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group sidebar-header-logo">
                <div class="w-10 h-10 bg-brand-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-brand-500/20 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <span class="font-display font-bold tracking-tight text-xl text-white sidebar-header-text">Admin Hub</span>
            </a>
            <button class="lg:hidden text-slate-400 hover:text-white p-2 rounded-lg hover:bg-white/10 transition" onclick="toggleSidebar()">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <nav class="flex-1 py-5 overflow-y-auto custom-scrollbar">
            <div class="px-6 mb-3 text-[10px] font-bold text-slate-500 uppercase tracking-widest sidebar-header-text">Main</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ $active == 'dashboard' ? 'active' : '' }}">
                <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.users') }}" class="nav-item {{ $active == 'users' ? 'active' : '' }}">
                <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <span>Users Directory</span>
            </a>
            <a href="{{ route('admin.requests') }}" class="nav-item {{ $active == 'requests' ? 'active' : '' }}">
                <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                <span>Manage Requests</span>
            </a>
            <div class="px-6 mt-6 mb-3 text-[10px] font-bold text-slate-500 uppercase tracking-widest sidebar-header-text">Reports</div>
            <a href="{{ route('admin.reports') }}" class="nav-item {{ $active == 'reports' ? 'active' : '' }}">
                <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Disputes</span>
            </a>
        </nav>

        <div class="p-4 border-t border-white/5">
            {{-- Collapse Toggle Button --}}
            <button onclick="toggleCollapse()" class="hidden lg:flex items-center justify-center w-full py-2 mb-4 rounded-xl bg-white/5 hover:bg-white/10 text-slate-400 hover:text-white transition-all text-xs font-bold uppercase tracking-widest">
                <span class="sidebar-footer-text">Collapse Menu</span>
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path></svg>
            </button>

            {{-- Account Dropdown --}}
            <div class="relative" x-data="{ open: false }" @click.away="open = false">
                <button @click="open = !open" class="flex items-center gap-3 p-2 rounded-xl hover:bg-white/5 transition group w-full text-left outline-none">
                    <div class="w-9 h-9 rounded-lg bg-brand-500/20 text-brand-400 flex items-center justify-center font-bold text-xs flex-shrink-0">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                    <div class="flex-1 min-w-0 sidebar-footer-text">
                        <p class="text-sm font-bold text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-[11px] text-slate-500 truncate flex items-center justify-between">
                            <span>Admin Account</span>
                            <svg class="w-3 h-3 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                        </p>
                    </div>
                </button>

                <div x-show="open"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="absolute bottom-full left-0 mb-2 w-full bg-slate-800 rounded-xl shadow-2xl border border-white/10 py-2 z-50 overflow-hidden"
                     style="display: none;">

                    <a href="{{ route('admin.profile') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-semibold text-slate-300 hover:bg-white/5 hover:text-white transition-colors">
                        <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        My Profile
                    </a>

                    <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-semibold text-slate-300 hover:bg-white/5 hover:text-white transition-colors">
                        <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Settings
                    </a>

                    <hr class="my-2 border-white/5">

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-3 w-full px-4 py-2.5 text-sm font-bold text-rose-400 hover:bg-rose-500/10 transition-colors text-left">
                            <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </aside>
</div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('mobile-overlay');
        sidebar.classList.toggle('mobile-open');
        if (sidebar.classList.contains('mobile-open')) {
            overlay.classList.remove('invisible', 'opacity-0');
        } else {
            overlay.classList.add('opacity-0');
            setTimeout(() => overlay.classList.add('invisible'), 300);
        }
    }

    function toggleCollapse() {
        const sidebar = document.getElementById('sidebar');
        const main = document.querySelector('main');
        sidebar.classList.toggle('sidebar-collapsed');
        const collapsed = sidebar.classList.contains('sidebar-collapsed');
        if (main) {
            main.style.marginLeft = collapsed ? '80px' : '270px';
        }
        localStorage.setItem('sidebar-collapsed', collapsed ? '1' : '0');
    }

    // Restore collapsed state on load
    (function() {
        if (window.innerWidth >= 1024 && localStorage.getItem('sidebar-collapsed') === '1') {
            const sidebar = document.getElementById('sidebar');
            const main = document.querySelector('main');
            if (sidebar) sidebar.classList.add('sidebar-collapsed');
            if (main) main.style.marginLeft = '80px';
        }
    })();
</script>
