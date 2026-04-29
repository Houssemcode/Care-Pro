{{-- Employee Navbar – @include('partials.employee-navbar', ['active' => 'dashboard']) --}}
<nav class="sticky top-0 z-40 bg-white/80 backdrop-blur-xl border-b border-slate-200 shadow-sm w-full">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 h-16 sm:h-20 flex justify-between items-center">
        {{-- Brand --}}
        <a href="{{ route('employee.dashboard') }}" class="flex items-center gap-2 cursor-pointer group">
            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-brand-500 rounded-lg sm:rounded-xl flex items-center justify-center text-white shadow-md group-hover:bg-brand-600 transition-colors">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <span class="font-display font-bold tracking-tight text-xl sm:text-2xl text-slate-900">CarePro</span>
        </a>

        {{-- Navigation --}}
        <div class="flex items-center gap-3 sm:gap-6">
            <a href="{{ route('employee.dashboard') }}" class="hidden md:block text-sm transition-colors cursor-pointer {{ ($active ?? '') == 'dashboard' ? 'text-brand-600 font-bold border-b-2 border-brand-500 pb-1' : 'text-slate-500 hover:text-brand-600 font-semibold' }}">Requests</a>
            <a href="{{ route('employee.offers') }}" class="hidden md:block text-sm transition-colors cursor-pointer {{ ($active ?? '') == 'offers' ? 'text-brand-600 font-bold border-b-2 border-brand-500 pb-1' : 'text-slate-500 hover:text-brand-600 font-semibold' }}">Offers</a>
            <a href="{{ route('employee.reports') }}" class="hidden md:block text-sm transition-colors cursor-pointer {{ ($active ?? '') == 'reports' ? 'text-brand-600 font-bold border-b-2 border-brand-500 pb-1' : 'text-slate-500 hover:text-brand-600 font-semibold' }}">Reports</a>

            <div class="hidden lg:block h-8 w-px bg-slate-200 ml-2"></div>

            {{-- Account Links --}}
            <a href="{{ route('employee.settings') }}" class="hidden lg:block text-sm transition-colors {{ ($active ?? '') == 'settings' ? 'text-brand-600 font-bold border-b-2 border-brand-500 pb-1' : 'text-slate-500 hover:text-brand-600 font-semibold' }}">Settings</a>
            <a href="{{ route('employee.logout') }}" class="hidden lg:block text-rose-500 hover:text-rose-600 font-semibold text-sm transition-colors">Logout</a>

            {{-- Profile Avatar --}}
            <a href="{{ route('employee.profile') }}" class="flex items-center gap-2 sm:gap-3 cursor-pointer group hover:bg-slate-50 p-1 sm:p-1.5 sm:pr-4 rounded-full transition-colors border border-transparent hover:border-slate-200">
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br from-brand-400 to-brand-600 border-2 border-white shadow-sm flex items-center justify-center text-white font-bold text-xs sm:text-sm flex-shrink-0 {{ ($active ?? '') == 'profile' ? 'ring-2 ring-brand-200' : '' }}">SB</div>
                <div class="hidden sm:flex flex-col">
                    <span class="text-sm font-semibold text-slate-800 leading-tight group-hover:text-brand-600 transition-colors whitespace-nowrap">Sonia Belkacem</span>
                    <span class="text-xs font-medium text-slate-500">Caregiver</span>
                </div>
            </a>
        </div>
    </div>

    {{-- Mobile Bottom Nav --}}
    <div class="md:hidden border-t border-slate-100 bg-white px-2 py-1.5 flex justify-around">
        <a href="{{ route('employee.dashboard') }}" class="flex flex-col items-center gap-0.5 px-3 py-1 rounded-xl text-xs font-bold transition-colors {{ ($active ?? '') == 'dashboard' ? 'text-brand-600' : 'text-slate-400' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            Requests
        </a>
        <a href="{{ route('employee.offers') }}" class="flex flex-col items-center gap-0.5 px-3 py-1 rounded-xl text-xs font-bold transition-colors {{ ($active ?? '') == 'offers' ? 'text-brand-600' : 'text-slate-400' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            Offers
        </a>
        <a href="{{ route('employee.reports') }}" class="flex flex-col items-center gap-0.5 px-3 py-1 rounded-xl text-xs font-bold transition-colors {{ ($active ?? '') == 'reports' ? 'text-brand-600' : 'text-slate-400' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            Reports
        </a>
        <a href="{{ route('employee.profile') }}" class="flex flex-col items-center gap-0.5 px-3 py-1 rounded-xl text-xs font-bold transition-colors {{ ($active ?? '') == 'profile' ? 'text-brand-600' : 'text-slate-400' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            Profile
        </a>
    </div>
</nav>
